'use strict';

module.exports = function (opt) {

    opt.gulp.task('cursor', function () {
        return opt.gulp.src('./src/pic/cursor/*.cur')
            .pipe(opt.load.plumber())
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/images/cursor/'));
    });
};