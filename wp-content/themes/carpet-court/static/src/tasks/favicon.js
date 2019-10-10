'use strict';

module.exports = function (opt) {

    opt.gulp.task('favicon', function () {
        return opt.gulp.src('./src/pic/favicon.png')
            .pipe(opt.load.plumber())
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR));
    });
};