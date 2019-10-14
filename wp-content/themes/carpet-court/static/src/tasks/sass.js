'use strict';

module.exports = function (opt) {

    // Собираем в строку динамические стили из компонентов
    opt.gulp.task('sass:create-string', function () {
        opt.styles = opt.getDynamicString(opt.name.scss);
    });

    // Компилируем SASS
    opt.gulp.task('sass:compile', opt.task.sassCompile = function () {
        return opt.gulp.src(opt.sass + 'appBefore.scss')// Нельзя начинать с _
            .pipe(opt.load.plumber())
            .pipe(opt.load.insert.append(opt.styles))// Добавляем в конец файла строки
            .pipe(opt.load.insert.append(opt.fs.readFileSync(opt.sass + 'appAfter.scss', opt.encoding)))
            .pipe(opt.load.sass({
                outputStyle: 'expanded'
            }).on('error', opt.load.sass.logError))
            .pipe(opt.load.inlineBase64({
                baseDir: './' + opt.DIR + '/images', // путь к папке из которой картинки преобр. в base64 через url('имя_картинки')
                maxSize: 1000 * 1000,
                debug: false // выкл. уведомления
            }))
            .pipe(opt.load.autoprefixer({
                browsers: [
                    '> 1%',
                    'last 2 versions',
                    'ie 11'
                ],
                cascade: false
            }))
            .pipe(opt.load.mergeMediaQueries({
                log: true
            }))
            .pipe(opt.load.cleanCss({
                advanced: false
            }))
            .pipe(opt.load.rename({
                basename: 'app',
                suffix: '.min'
            }))
            //.pipe(opt.load.header(opt.banner, { pkg : opt.pkg } ))
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/css'))
            .pipe(opt.browserSync.stream());
    });

    // Общая задача SASS
    opt.gulp.task('sass', ['sass:create-string'], opt.task.sassCompile);
    //opt.gulp.task('sass-sync', ['sass'], opt.reload);
};