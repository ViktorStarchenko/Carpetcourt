<?php

// session_start();
function cpm_measuer_and_quote_form() { ?>

<div role="form" class="wpcf7" id="cpm-book">

    <form action="" method="post" class="wpcf7-form" id="cpm-measures-quote">

        <span class="form-control-wrap product_name">
            <input name="product_name" value="<?php echo get_the_title(); ?>" size="40" class="form-control cpmdtx-dynamictext wpcf7-dynamichidden" aria-invalid="false" type="hidden">
        </span>
        <div id="free-measure-and-quote">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-field">
                        <label>Your Name (required)</label><br>
                        <span class="form-control-wrap your-name">
                            <input name="your_name" value="" size="40" class="form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" type="text">
                        </span>
                    </div>
                    <div class="form-field">
                        <label>Your Email (required)</label><br>
                        <span class="form-control-wrap your-email">
                            <input name="your_email" value="" size="40" class="form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false" type="email">
                        </span>
                    </div>
                    <div class="form-field">
                        <label>Your Address (required)</label><br>
                        <span class="form-control-wrap street-address">
                            <input name="street_address" value="" size="40" class="form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false" type="text">
                        </span>
                    </div>
                    <div class="form-field">
                        <label>City/Town</label><br>
                        <span class="form-control-wrap cities-towns">
                            <select name="cities_towns" class="form-control wpcf7-select" aria-invalid="false">
                                <option value="Aruba">Aruba</option>
                                <option value="Afghanistan">Afghanistan</option>
                                <option value="Angola">Angola</option>
                                <option value="Anguilla">Anguilla</option>
                                <option value="Åland Islands">Åland Islands</option>
                                <option value="Albania">Albania</option>
                                <option value="Andorra">Andorra</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Armenia">Armenia</option>
                                <option value="American Samoa">American Samoa</option>
                                <option value="Antarctica">Antarctica</option>
                                <option value="French Southern Territories">French Southern Territories</option>
                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                <option value="Australia">Australia</option>
                                <option value="Austria">Austria</option>
                                <option value="Azerbaijan">Azerbaijan</option>
                                <option value="Burundi">Burundi</option>
                                <option value="Belgium">Belgium</option>
                                <option value="Benin">Benin</option>
                                <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                                <option value="Burkina Faso">Burkina Faso</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Bulgaria">Bulgaria</option>
                                <option value="Bahrain">Bahrain</option>
                                <option value="Bahamas">Bahamas</option>
                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                <option value="Saint Barthélemy">Saint Barthélemy</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Belize">Belize</option>
                                <option value="Bermuda">Bermuda</option>
                                <option value="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Barbados">Barbados</option>
                                <option value="Brunei Darussalam">Brunei Darussalam</option>
                                <option value="Bhutan">Bhutan</option>
                                <option value="Bouvet Island">Bouvet Island</option>
                                <option value="Botswana">Botswana</option>
                                <option value="Central African Republic">Central African Republic</option>
                                <option value="Canada">Canada</option>
                                <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                <option value="Switzerland">Switzerland</option>
                                <option value="Chile">Chile</option>
                                <option value="China">China</option>
                                <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                <option value="Cameroon">Cameroon</option>
                                <option value="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
                                <option value="Congo">Congo</option>
                                <option value="Cook Islands">Cook Islands</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Comoros">Comoros</option>
                                <option value="Cape Verde">Cape Verde</option>
                                <option value="Costa Rica">Costa Rica</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Curaçao">Curaçao</option>
                                <option value="Christmas Island">Christmas Island</option>
                                <option value="Cayman Islands">Cayman Islands</option>
                                <option value="Cyprus">Cyprus</option>
                                <option value="Czech Republic">Czech Republic</option>
                                <option value="Germany">Germany</option>
                                <option value="Djibouti">Djibouti</option>
                                <option value="Dominica">Dominica</option>
                                <option value="Denmark">Denmark</option>
                                <option value="Dominican Republic">Dominican Republic</option>
                                <option value="Algeria">Algeria</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="Egypt">Egypt</option>
                                <option value="Eritrea">Eritrea</option>
                                <option value="Western Sahara">Western Sahara</option>
                                <option value="Spain">Spain</option>
                                <option value="Estonia">Estonia</option>
                                <option value="Ethiopia">Ethiopia</option>
                                <option value="Finland">Finland</option>
                                <option value="Fiji">Fiji</option>
                                <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                <option value="France">France</option>
                                <option value="Faroe Islands">Faroe Islands</option>
                                <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                <option value="Gabon">Gabon</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Guernsey">Guernsey</option>
                                <option value="Ghana">Ghana</option>
                                <option value="Gibraltar">Gibraltar</option>
                                <option value="Guinea">Guinea</option>
                                <option value="Guadeloupe">Guadeloupe</option>
                                <option value="Gambia">Gambia</option>
                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                <option value="Greece">Greece</option>
                                <option value="Grenada">Grenada</option>
                                <option value="Greenland">Greenland</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="French Guiana">French Guiana</option>
                                <option value="Guam">Guam</option>
                                <option value="Guyana">Guyana</option>
                                <option value="Hong Kong">Hong Kong</option>
                                <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Croatia">Croatia</option>
                                <option value="Haiti">Haiti</option>
                                <option value="Hungary">Hungary</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Isle of Man">Isle of Man</option>
                                <option value="India">India</option>
                                <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                <option value="Ireland">Ireland</option>
                                <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                <option value="Iraq">Iraq</option>
                                <option value="Iceland">Iceland</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Jamaica">Jamaica</option>
                                <option value="Jersey">Jersey</option>
                                <option value="Jordan">Jordan</option>
                                <option value="Japan">Japan</option>
                                <option value="Kazakhstan">Kazakhstan</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Kiribati">Kiribati</option>
                                <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                <option value="Korea, Republic of">Korea, Republic of</option>
                                <option value="Kuwait">Kuwait</option>
                                <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                <option value="Lebanon">Lebanon</option>
                                <option value="Liberia">Liberia</option>
                                <option value="Libya">Libya</option>
                                <option value="Saint Lucia">Saint Lucia</option>
                                <option value="Liechtenstein">Liechtenstein</option>
                                <option value="Sri Lanka">Sri Lanka</option>
                                <option value="Lesotho">Lesotho</option>
                                <option value="Lithuania">Lithuania</option>
                                <option value="Luxembourg">Luxembourg</option>
                                <option value="Latvia">Latvia</option>
                                <option value="Macao">Macao</option>
                                <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                                <option value="Morocco">Morocco</option>
                                <option value="Monaco">Monaco</option>
                                <option value="Moldova, Republic of">Moldova, Republic of</option>
                                <option value="Madagascar">Madagascar</option>
                                <option value="Maldives">Maldives</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Marshall Islands">Marshall Islands</option>
                                <option value="Macedonia, the former Yugoslav Republic of">Macedonia, the former Yugoslav Republic of</option>
                                <option value="Mali">Mali</option>
                                <option value="Malta">Malta</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Montenegro">Montenegro</option>
                                <option value="Mongolia">Mongolia</option>
                                <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                <option value="Mozambique">Mozambique</option>
                                <option value="Mauritania">Mauritania</option>
                                <option value="Montserrat">Montserrat</option>
                                <option value="Martinique">Martinique</option>
                                <option value="Mauritius">Mauritius</option>
                                <option value="Malawi">Malawi</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Mayotte">Mayotte</option>
                                <option value="Namibia">Namibia</option>
                                <option value="New Caledonia">New Caledonia</option>
                                <option value="Niger">Niger</option>
                                <option value="Norfolk Island">Norfolk Island</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Niue">Niue</option>
                                <option value="Netherlands">Netherlands</option>
                                <option value="Norway">Norway</option>
                                <option value="Nepal">Nepal</option>
                                <option value="Nauru">Nauru</option>
                                <option value="New Zealand">New Zealand</option>
                                <option value="Oman">Oman</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="Panama">Panama</option>
                                <option value="Pitcairn">Pitcairn</option>
                                <option value="Peru">Peru</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Palau">Palau</option>
                                <option value="Papua New Guinea">Papua New Guinea</option>
                                <option value="Poland">Poland</option>
                                <option value="Puerto Rico">Puerto Rico</option>
                                <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Palestine, State of">Palestine, State of</option>
                                <option value="French Polynesia">French Polynesia</option>
                                <option value="Qatar">Qatar</option>
                                <option value="Réunion">Réunion</option>
                                <option value="Romania">Romania</option>
                                <option value="Russian Federation">Russian Federation</option>
                                <option value="Rwanda">Rwanda</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                                <option value="Sudan">Sudan</option>
                                <option value="Senegal">Senegal</option>
                                <option value="Singapore">Singapore</option>
                                <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
                                <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
                                <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                <option value="Solomon Islands">Solomon Islands</option>
                                <option value="Sierra Leone">Sierra Leone</option>
                                <option value="El Salvador">El Salvador</option>
                                <option value="San Marino">San Marino</option>
                                <option value="Somalia">Somalia</option>
                                <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                <option value="Serbia">Serbia</option>
                                <option value="South Sudan">South Sudan</option>
                                <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                <option value="Suriname">Suriname</option>
                                <option value="Slovakia">Slovakia</option>
                                <option value="Slovenia">Slovenia</option>
                                <option value="Sweden">Sweden</option>
                                <option value="Swaziland">Swaziland</option>
                                <option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
                                <option value="Seychelles">Seychelles</option>
                                <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                <option value="Chad">Chad</option>
                                <option value="Togo">Togo</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Tajikistan">Tajikistan</option>
                                <option value="Tokelau">Tokelau</option>
                                <option value="Turkmenistan">Turkmenistan</option>
                                <option value="Timor-Leste">Timor-Leste</option>
                                <option value="Tonga">Tonga</option>
                                <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                <option value="Tunisia">Tunisia</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Tuvalu">Tuvalu</option>
                                <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                <option value="Uganda">Uganda</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="United States">United States</option>
                                <option value="Uzbekistan">Uzbekistan</option>
                                <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                <option value="Venezuela, Bolivarian Republic of">Venezuela, Bolivarian Republic of</option>
                                <option value="Virgin Islands, British">Virgin Islands, British</option>
                                <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                <option value="Viet Nam">Viet Nam</option>
                                <option value="Vanuatu">Vanuatu</option>
                                <option value="Wallis and Futuna">Wallis and Futuna</option>
                                <option value="Samoa">Samoa</option>
                                <option value="Yemen">Yemen</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Zambia">Zambia</option>
                                <option value="Zimbabwe">Zimbabwe</option>
                            </select>
                        </span>
                    </div>
                    <div class="form-field">
                        <label>Day phone number</label><br>
                        <span class="form-control-wrap day-phone-number">
                            <input name="day_phone_number" value="" size="40" class="form-control wpcf7-text wpcf7-tel wpcf7-validates-as-tel" aria-invalid="false" type="tel">
                        </span>
                    </div>
                    <div class="form-field">
                        <label><b>Please select the Carpet Court store nearest you:</b></label><br>
                        <span class="form-control-wrap nearest-store">
                            <select name="nearest_store" class="form-control wpcf7-select wpcf7-validates-as-required selectize" aria-required="true" aria-invalid="false">
                                <option value="">---</option>
                                <option value="albany@carpetcourt.co.nz">Albany</option>
                                <option value="carpetcourt_ashburton@xtra.co.nz">Ashburton</option>
                                <option value="jo@blenheimcarpetcourt.co.nz">Blenheim</option>
                                <option value="botany@carpetcourt.co.nz">Botany</option>
                                <option value="cambridge@carpetcourt.co.nz">Cambridge-Wilson's</option>
                                <option value="Christchurch@carpetcourtchch.co.nz">Christchurch City</option>
                                <option value="moorhouse@carpetcourt.co.nz">Christchurch Moorhouse Ave</option>
                                <option value="hornby@carpetcourt.co.nz">Christchurch Blenheim Rd</option>
                                <option value="dunedin-info@carpetcourt.nz">Dunedin</option>
                                <option value="carpetcourtdnsouth@xtra.co.nz">Dunedin South</option>
                                <option value="roger.faber@carpetcourtgis.co.nz">Gisborne</option>
                                <option value="addisons.greymouth@xtra.co.nz">Greymouth</option>
                                <option value="hamilton@carpetcourt.co.nz">Hamilton</option>
                                <option value="henderson@carpetcourt.co.nz">Henderson</option>
                                <option value="hokitika@carpetcourt.co.nz">Hokitika</option>
                                <option value="invercargill@carpetcourt.co.nz">Invercargill</option>
                                <option value="kaiapoi@carpetcourt.co.nz">Kaiapoi North Canterbury</option>
                                <option value="Rosanne.Taylor@carpetcourt.nz">Kaitaia</option>
                                <option value="waikanae@carpetcourt.co.nz">Kapiti Waikanae</option>
                                <option value="info@ccherikeri.co.nz">Kerikeri</option>
                                <option value="levin@carpetcourt.co.nz">Levin (Timms)</option>
                                <option value="lowerhutt@carpetcourt.co.nz">Lower Hutt</option>
                                <option value="manukau@carpetcourt.co.nz">Manukau</option>
                                <option value="sales-masterton@carpetcourt.nz">Masterton (Mckenzies)</option>
                                <option value="flooring@watersons.co.nz">Matamata</option>
                                <option value="morrinsville@colourplus.co.nz">Morrinsville</option>
                                <option value="mtmaunganui@carpetcourt.co.nz">Mt Maunganui</option>
                                <option value="mtroskill@carpetcourt.co.nz">Mt Roskill</option>
                                <option value="mtwellington@carpetcourt.co.nz">Mt Wellington</option>
                                <option value="napier@carpetcourt.co.nz">Napier</option>
                                <option value="nelson@carpetcourt.co.nz">Nelson</option>
                                <option value="newplymouth@carpetcourt.co.nz">New Plymouth</option>
                                <option value="Kerry.coulton@carpetcourt.nz">New Plymouth Rapleys</option>
                                <option value="newmarket@carpetcourt.co.nz">Newmarket</option>
                                <option value="neil.bovey@carpetcourt.nz">Palmerston North</option>
                                <option value="paraparaumu@carpetcourt.co.nz">Paraparaumu</option>
                                <option value="porirua@carpetcourt.co.nz">Porirua</option>
                                <option value="pukekohe@carpetcourt.nz">Pukekohe</option>
                                <option value="queenstown@carpetcourt.co.nz">Queenstown</option>
                                <option value="rotorua@carpetcourt.co.nz">Rotorua</option>
                                <option value="terry.higgins@carpetcourt.nz">Silverdale</option>
                                <option value="sales@carpetcourtstlukes.co.nz">St Lukes</option>
                                <option value="takanini@carpetcourt.nz">Takanini</option>
                                <option value="grant.ridley@carpetcourt.nz">Taupo</option>
                                <option value="tauranga@carpetcourt.co.nz">Tauranga</option>
                                <option value="teawamutu@carpetcourt.co.nz">Te Awamutu</option>
                                <option value="Timaru">Timaru</option>
                                <option value="info@dorescarpetcourt.co.nz">Timaru (Dores)</option>
                                <option value="upperhutt@carpetcourt.co.nz">Upper Hutt (Carpet Smart)</option>
                                <option value="info@carpetcourtwaiheke.co.nz">Waiheke</option>
                                <option value="wairaupark@carpetcourt.co.nz">Wairau Park</option>
                                <option value="wanaka@carpetcourt.co.nz">Wanaka (Lakeland)</option>
                                <option value="wellingtoncity@carpetcourt.co.nz">Wellington City</option>
                                <option value="scott.lawrence@carpetcourt.nz">Wellington Thorndon</option>
                                <option value="mike.simpson@carpetcourt.nz">Whanganui</option>
                                <option value="whangarei@carpetcourt.co.nz">Whangarei</option>
                                <option value="wordpress.enthusiast.test@gmail.com">Test</option>
                                <option value="patrick@jadecreative.co.nz">Test2</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-field">
                        <label>I am interested in:</label><br>

                        <span class="wpcf7-form-control-wrap interested-in">
                            <span class="wpcf7-form-control wpcf7-checkbox">
                                <span class="wpcf7-list-item first">
                                    <input name="interested_in[]" class="cpm_interests" value="Carpet" type="checkbox">&nbsp;
                                    <span class="wpcf7-list-item-label">Carpet</span>
                                </span>
                                <span class="wpcf7-list-item">
                                    <input name="interested_in[]" class="cpm_interests" value="Vinyl" type="checkbox">&nbsp;
                                    <span class="wpcf7-list-item-label">Vinyl</span>
                                </span>
                                <span class="wpcf7-list-item">
                                    <input name="interested_in[]" class="cpm_interests" value="Ceramic Tiles" type="checkbox">&nbsp;
                                    <span class="wpcf7-list-item-label">Ceramic Tiles</span>
                                </span>
                                <span class="wpcf7-list-item">
                                    <input name="interested_in[]" class="cpm_interests" value="Rugs" type="checkbox">&nbsp;
                                    <span class="wpcf7-list-item-label">Rugs</span>
                                </span>
                                <span class="wpcf7-list-item">
                                    <input name="interested_in[]" class="cpm_interests" value="Timber Floors" type="checkbox">&nbsp;
                                    <span class="wpcf7-list-item-label">Timber Floors</span>
                                </span>
                                <span class="wpcf7-list-item last">
                                    <input name="interested_in[]" class="cpm_interests" value="Other" type="checkbox">&nbsp;
                                    <span class="wpcf7-list-item-label">Other</span>
                                </span>
                            </span>
                        </span>

                    </div>
                    <div class="form-field">
                        <label>Preferred date:</label><br>
                        <span class="form-control-wrap preferred-date">
                            <input id="dp1462509837894" name="preferred_date" value="" size="40" class="form-control wpcf7-date hasDatepicker" type="text">
                        </span>
                    </div>
                    <div class="form-field">
                        <label>If you have a promo code, please enter it here:</label><br>
                        <span class="form-control-wrap promo-code">
                            <input name="promo_code" value="" size="40" class="form-control wpcf7-text" aria-invalid="false" type="text">
                        </span>
                    </div>
                    <div class="form-field">
                        <label>Your Message</label><br>
                        <span class="form-control-wrap your-message">
                            <textarea name="your_message" cols="40" rows="10" class="form-control wpcf7-textarea" aria-invalid="false"></textarea>
                        </span>
                    </div>
                    <?php

                    if ( isset($_GET['product_color'] ) && !empty( $_GET['product_color'] ) ) { ?>
                      <input type="hidden" name="selected[product_color]" value="<?php echo $_GET['product_color']; ?>">
                      <?php
                    }
                    if ( isset($_POST['product_color'] ) && !empty( $_POST['product_color'] ) ) { ?>
                      <input type="hidden" name="selected[product_color]" value="<?php echo $_POST['product_color']; ?>">
                      <?php
                    }

                    if ( isset($_GET['pa_floor'] ) && !empty( $_GET['pa_floor'] ) ) {
                        foreach ($_GET['pa_floor'] as $pa_floor_value) {
                            ?>
                            <input type="hidden" name="selected[pa_floor]" value="<?php echo $pa_floor_value; ?>">
                        <?php
                        }
                    }
                    if ( isset($_POST['pa_floor'][0] ) && !empty( $_POST['pa_floor'][0] ) ) {
                        foreach ($_POST['pa_floor'] as $pa_floor_value) {
                            ?>
                            <input type="hidden" name="selected[pa_floor]" value="<?php echo $pa_floor_value; ?>">
                        <?php
                        }
                    }

                    if ( isset($_GET['pa_rent'] ) && !empty( $_GET['pa_rent'] ) ) {
                        foreach ($_GET['pa_rent'] as $pa_rent_value) { ?>
                            <input type="hidden" name="selected[pa_rent]" value="<?php echo $pa_rent_value; ?>">
                        <?php
                        }
                    }
                    if ( isset($_POST['pa_rent'][0] ) && !empty( $_POST['pa_rent'][0] ) ) {
                        foreach ($_POST['pa_rent'] as $pa_rent_value) { ?>
                            <input type="hidden" name="selected[pa_rent]" value="<?php echo $pa_rent_value; ?>">
                        <?php
                        }
                    }

                    if ( isset($_GET['pa_style'] ) && !empty( $_GET['pa_style'] ) ) {
                        foreach ($_GET['pa_style'] as $pa_style_value) { ?>
                            <input type="hidden" name="selected[pa_style]" value="<?php echo $pa_style_value; ?>">
                        <?php
                        }
                    }
                    if ( isset($_POST['pa_style'][0] ) && !empty( $_POST['pa_style'][0] ) ) {
                        foreach ($_POST['pa_style'] as $pa_style_value) { ?>
                            <input type="hidden" name="selected[pa_style]" value="<?php echo $pa_style_value; ?>">
                        <?php
                        }
                    }

                    if ( isset($_GET['product_cat'] ) && !empty( $_GET['product_cat'] ) ) {
                        foreach ($_GET['product_cat'] as $product_cat_value) { ?>
                            <input type="hidden" name="selected[product_cat]" value="<?php echo $product_cat_value; ?>">
                        <?php
                        }
                    }

                    if ( !empty( $_POST['product_cat'][0] ) && isset( $_POST['product_cat'][0] ) ) {
                        foreach ($_POST['product_cat'] as $product_cat_value) { ?>
                            <input type="hidden" name="selected[product_cat]" value="<?php echo $product_cat_value; ?>">
                        <?php
                        }

                    }

                    if ( isset($_GET['product_brand'] ) && !empty( $_GET['product_brand'] ) ) {
                        foreach ($_GET['product_brand'] as $product_brand_value) { ?>
                            <input type="hidden" name="selected[product_brand]" value="<?php echo $product_brand_value; ?>">
                        <?php
                        }
                    }
                    if ( isset($_POST['product_brand'][0] ) && !empty( $_POST['product_brand'][0] ) ) {
                        foreach ($_POST['product_brand'] as $product_brand_value) { ?>
                            <input type="hidden" name="selected[product_brand]" value="<?php echo $product_brand_value; ?>">
                        <?php
                        }
                    }

                    if ( isset($_GET['pa_rooms'] ) && !empty( $_GET['pa_rooms'] ) ) {
                        foreach ($_GET['pa_rooms'] as $pa_rooms_value) { ?>
                            <input type="hidden" name="selected[pa_rooms]" value="<?php echo $pa_rooms_value; ?>">
                        <?php
                        }
                    }
                    if ( isset($_POST['pa_rooms'][0] ) && !empty( $_POST['pa_rooms'][0] ) ) {
                        foreach ($_POST['pa_rooms'] as $pa_rooms_value) { ?>
                            <input type="hidden" name="selected[pa_rooms]" value="<?php echo $pa_rooms_value; ?>">
                        <?php
                        }
                    }

                    if ( isset($_GET['child_product_color'] ) && !empty( $_GET['child_product_color'] ) ) {
                    $child_product_color = $_GET['child_product_color'];
                        ?>
                            <input type="hidden" name="selected[product_color]" value="<?php echo $child_product_color; ?>">
                        <?php
                    }
                    if ( isset($_POST['child_product_color'] ) && !empty( $_POST['child_product_color'] ) ) {
                    $child_product_color = $_POST['child_product_color'];
                        ?>
                            <input type="hidden" name="selected[product_color]" value="<?php echo $child_product_color; ?>">
                        <?php
                    }
                    ?>
                    <input value="Send" class="wpcf7-form-control wpcf7-submit" type="submit">

                </div>
            </div>
            <div class="wpcf7-response-output"></div>
        </div>
    </form>
</div>

<?php
}