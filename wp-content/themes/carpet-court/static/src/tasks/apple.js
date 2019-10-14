'use strict';

module.exports = function (opt) {

    opt.gulp.task('apple', function () {// Сжимаем apple-touch
        return opt.gulp.src('./src/pic/apple-touch-icon.png')
            .pipe(opt.load.plumber())
            //.pipe(opt.load.imagemin())
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR));
    });
};