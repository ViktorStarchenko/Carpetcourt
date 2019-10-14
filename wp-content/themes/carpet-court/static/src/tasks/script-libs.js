'use strict';

module.exports = function (opt) {

    opt.gulp.task('libs-uglify', function () {
        return opt.gulp.src(['./src/js/libs/**/*.js', '!./src/js/libs/**/*.min.js'])
            .pipe(opt.load.plumber())
            .pipe(opt.load.changed('./' + opt.DIR + '/js/libs'))
            .pipe(opt.load.uglify())
            .pipe(opt.load.rename({suffix: '.min'}))
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/js/libs'))
    });

    opt.gulp.task('libs-copy', function () {
        return opt.gulp.src('./src/js/libs/**/*.min.js')
            .pipe(opt.load.plumber())
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/js/libs'))
    });

    opt.gulp.task(
        'script-libs',
        [
            'libs-uglify',
            'libs-copy'
        ]);

    opt.gulp.task('script-libs-sync', ['script-libs'], opt.reload);
};