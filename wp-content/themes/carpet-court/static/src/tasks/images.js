'use strict';

module.exports = function (opt) {

    // Очищаем папку с картинками
    opt.gulp.task('images:del', function () {
        return opt.del([
            './' + opt.DIR + '/images'
        ]);
    });

    // Собираем пути картинок из модулей в массив
    opt.gulp.task('images:getImgArr', opt.task.getImgArr = function () {
        // массив путей картинок из компонентов images
        opt.arrImages = opt.getImgArrPath('images');
    });

    // Минимизируем и копируем картинки из images
    opt.gulp.task('images:mini', opt.task.imgMini = function () {
        return opt.gulp.src(opt.arrImages)
            .pipe(opt.load.plumber())
            /*.pipe(opt.load.imagemin([
                opt.load.imagemin.gifsicle(),
                // https://www.npmjs.com/package/imagemin-mozjpeg#quality
                opt.imageminMozjpeg({
                    dcScanOpt: 2,
                    quality: 85 // default: 79
                }),
                opt.load.imagemin.optipng(),
                opt.load.imagemin.svgo()
            ], {
                progressive: true
            }))*/
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/images'));
    });

    // Общая задача по сборке картинок
    opt.gulp.task('images-tmp', ['images:del'], opt.task.getImgArr);
    opt.gulp.task('images', ['images-tmp'], opt.task.imgMini);
    opt.gulp.task('images-sync', ['images'], opt.reload);
};