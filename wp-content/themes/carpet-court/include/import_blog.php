<?php
include 'libs/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderFactory;
use Box\Spout\Common\Type;
add_action('admin_menu', 'import_plugin_setup_menu');

function import_plugin_setup_menu(){
	add_menu_page( 'Import blog posts', 'Import blog posts', 'manage_options', 'import-blog', 'import_init' );
}

function import_init() {
	import_from_file();

	echo '<h1>There you can import blog posts from csv, odc or xlsx files!</h1>';
	echo '<h2>Upload a File</h2>';
	echo '<form  method="post" enctype="multipart/form-data">';
	echo '<input type="file" id="upload_csv" name="upload_csv"></input>';
	submit_button('Upload');
	echo '</form>';
}
// The functions which is going to do the job
function import_from_file()
{
	//define('ALLOW_UNFILTERED_UPLOADS', true);

	$allowed_file_types = [
		'xlsx',
		'csv',
		'ods'
	];

	if (isset($_FILES['upload_csv'])) {
		$csv = $_FILES['upload_csv'];

		$uploaded = media_handle_upload('upload_csv', 0);
		// Error checking using WP functions
		if (is_wp_error($uploaded)) {
			echo "Error uploading file: " . $uploaded->get_error_message();
		} else {
			$data = array();
			$errors = array();
			set_time_limit(0);

			// Require some Wordpress core files for processing images
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');

			// Download and parse the xlsx
			$filePath = get_attached_file($uploaded);


			$paramms = [
				'migrate'=>0,
				'title'=>1,
				'date'=>2,
				'categories'=>3,
				'description'=>4,
				'old_url'=>5,
				'tags'=>6,
				'images'=>7,
				'images_text'=>8
			];

			$ext = pathinfo($csv['name'], PATHINFO_EXTENSION);
			if (!in_array($ext, $allowed_file_types)) {
				$errors[] = 'Import allowed only for .xlsx, .csv and .ods files';
			} else {
				if (is_readable($filePath)) {
					$type = Type::XLSX;
					switch ($ext) {
						case 'xlsx':
							$type = Type::XLSX;
							break;
						case 'csv':
							$type = Type::CSV;
							break;
						case 'ods':
							$type = Type::ODS;
							break;
						default:
							$type = Type::XLSX;
							break;
					}

					$reader = ReaderFactory::createFromType($type);
					$reader->open($filePath);
					$i = 0;
					foreach ($reader->getSheetIterator() as $sheet) {
						$y = 0;
						foreach ($sheet->getRowIterator() as $r) {
							$row = $r->toArray();

								$postCreated = [
									'post_title' => trim($row[$paramms['title']]),
									'post_status' => 'publish',
									'post_type' => 'post',
								];
								if (!empty($row[$paramms['date']])) {
									$format = "d/m/Y";
									$dateobj = DateTime::createFromFormat($format, $row[$paramms['date']]);
									if($dateobj){
										$postCreated['post_date'] = $dateobj->format("Y-m-d");
									}
								}

								$categories = get_categories([
										'hide_empty'   => 0,
									]
								);
								$post_cats = [];
								$tags = [];

								if (!empty($row[$paramms['tags']])) {
									$tags = explode(",", $row[$paramms['tags']]);
									foreach ($tags as &$tag) {
										$tag = str_replace('#', '', trim($tag));
									}
								}

								if (!empty($row[$paramms['categories']])) {
									preg_match_all('`"([^"]*)"`', $row[$paramms['categories']], $results);
									foreach ($categories as $cat) {
										foreach ($results[1] as $result) {
											if ($result == $cat->name) {
												$post_cats[] = $cat->cat_ID;
											}
										}
									}
								}

								$descriptionImages = getImagesID($row[$paramms['images']]);

								$descriptionImagesText = getImagesText($row[$paramms['images_text']]);

								$description = importDescription($row[$paramms['description']], $descriptionImages, $descriptionImagesText);

								if (!empty($description)) {
									$postCreated['post_content'] = $description;
								}

								$post = get_page_by_title($row[$paramms['title']], 'OBJECT', 'post');

								if (isset($post->ID)) {
									$ID = $post->ID;
								} else {
									unset($ID);
								}

								if ($row[$paramms['migrate']] == 'YES') {
									if (isset($ID)) {
										$postCreated['ID'] = $ID;
										wp_update_post($postCreated);
										echo "Post ".$row[$paramms['title']]." (".$ID.") already exists. Update.<br>";
									} else {
										$ID = wp_insert_post($postCreated);
										echo "Post ".$row[$paramms['title']]." (".$ID.") insert.<br>";
									}

									if (!empty($post_cats)) {
										wp_set_post_categories($ID, $post_cats);
									}

									if (!empty($descriptionImages)) {
										update_post_meta($ID, '_thumbnail_id', $descriptionImages[0]);
									}
									if (!empty($tags)) {
										wp_set_post_tags($ID, $tags);
									}
								}


								$y++;

								 if ($y > 6) {
									 break;
								 }

						}
						$i++;
					}

					$reader->close();

					//dump($group);

				} else {
					$errors[] = "File '$filePath' could not be opened. Check the file's permissions to make sure it's readable by your server.";
				}

				if (!empty($errors)) {
					foreach ($errors as $error) {
						echo $error;
					}
				} else {
					echo 'Import finished!';
				}
			}
		}
	}
}

function importDescription($text, $descriptionImages, $descriptionImagesText = null)
{
	$description = '';
	if (!empty($text)) {
		$description = $text;
	}

	if (!empty($descriptionImages)) {
		foreach ($descriptionImages as $key => $image) {
			$data = [];
			$imageURL = '';
			$data = wp_get_attachment_image_src($image, 'large');
			$imageURL = $data[0];
			if (!empty($imageURL)) {
				$appURL = home_url();
				$imageURL = str_replace($appURL, '', $imageURL);
				$text = '';
				if (!empty($descriptionImagesText[$key+1])){
					$text = '<p style="text-align: center;">'.$descriptionImagesText[$key+1]['text'] . '</p>';
				}
				$description .= '<p><img src="' . $imageURL . '" alt="" /></p>'.$text;
			}

		}
	}

	return $description;
}

function getImagesID($imagesData, $postID = null)
{
	$imagesID = [];

	if (!empty($imagesData)) {
		$imagesArr = explode("\n", $imagesData);
		$imagesArr = array_filter($imagesArr, 'strlen');
		if (!empty($imagesArr)) {
			foreach ($imagesArr as &$link) {
				$link = preg_replace('/^[0-9]+\. +/', '', $link);
				$imagesID[] = importBlogImages($link, $postID);
			}
		}
	}

	return $imagesID;
}

function getImagesText($data)
{
	$text = [];

	if (!empty($data)) {
		$textArr = explode("\n", $data);
		$textArr = array_filter($textArr, 'strlen');

		foreach ($textArr as $element) {
			$text[intval($element[0])]['text'] = preg_replace('/^[0-9]+\. +/', '', $element);
		}

	}

	return $text;
}

function importBlogImages($file, $postID = null, $fileDescription = null)
{
	global $debug;

	if (!function_exists('media_handle_sideload')) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
	}

	$tmp = download_url($file);

	$fileArray = [
		'name'     => basename($file),
		'tmp_name' => $tmp
	];

	if (is_wp_error($tmp)) {
		$fileArray['tmp_name'] = '';
		if ($debug) {
			echo 'Error temp file! <br/>';
		}
	}

	if ($debug) {
		echo 'File array: <br />';
		var_dump($fileArray);
		echo '<br /> Post id: ' . $postID . '<br />';
	}

	$attachment = wp_get_attachment_by_post_name($fileArray['name']);
	if (!empty($attachment)) {
		$id = $attachment->ID;
		if (!empty($postID)) {
			update_post_meta($postID, '_thumbnail_id', $id);
		}
	} else {
		$id = media_handle_sideload($fileArray, $postID, $fileDescription);
		if (is_wp_error($id)) {
			var_dump($id->get_error_messages());
		} else {
			if (!empty($postID)) {
				update_post_meta($postID, '_thumbnail_id', $id);
			}
		}
	}

	@unlink($tmp);

	return $id;
}

if (!(function_exists('wp_get_attachment_by_post_name'))) {
	function wp_get_attachment_by_post_name($post_name)
	{
		$title = preg_replace('/\.[^.]+$/', '', wp_basename($post_name));

		$args = array(
			'posts_per_page' => 1,
			'post_type'      => 'attachment',
			'name'           => trim($title),
		);

		$get_attachment = new WP_Query($args);

		if (!$get_attachment || !isset($get_attachment->posts, $get_attachment->posts[0])) {
			return false;
		}

		return $get_attachment->posts[0];
	}
}
