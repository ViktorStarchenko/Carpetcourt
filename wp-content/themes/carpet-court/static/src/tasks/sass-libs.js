'use strict';

module.exports = function (opt) {

    opt.gulp.task('sass-libs', function () {
        return opt.gulp.src(['./src/scss/libs/*.scss'])
            .pipe(opt.load.plumber())
            .pipe(opt.load.sass({
                outputStyle: 'expanded'
            }).on('error', opt.load.sass.logError))
            .pipe(opt.load.autoprefixer({
                browsers: [
                    '> 1%',
                    'last 2 versions',
                    'ie 11'
                ],
                cascade: false
            }))
            .pipe(opt.load.cleanCss({
                advanced: false
            }))
            .pipe(opt.load.rename({suffix: '.min'}))
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/css/libs'));
    });
    opt.gulp.task('sass-libs-sync', ['sass-libs'], opt.reload);
};