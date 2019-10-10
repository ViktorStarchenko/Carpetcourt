'use strict';

module.exports = function (opt) {

    // Собираем список модулей
    opt.gulp.task('getModules', function () {

        var htmlParser = {

            // Из локального пути убираем множество ../../
            deletePoints: function (path) {
                if (path.indexOf('../') > -1) {

                    // Определяем позицию ../
                    var slashPos = path.indexOf('../');

                    // Удаляем 1 уровень слева от ../
                    var stringWithoutSlash = path.substring(0, slashPos - 1);
                    var stringWithoutOneLvlPos = stringWithoutSlash.lastIndexOf('/');
                    var stringWithoutOneLvl = stringWithoutSlash.substring(0, stringWithoutOneLvlPos + 1);

                    // Удаляем 1 уровень справа от ../
                    var stringWithoutPoints = path.substring(slashPos, path.length);
                    var stringWithoutOnePoints = stringWithoutPoints.substring(3, stringWithoutPoints.length);

                    // Склеиваем обратно в одну строку
                    var fixedPath = stringWithoutOneLvl + stringWithoutOnePoints;

                    return this.deletePoints(fixedPath);
                } else {
                    return path;
                }
            },

            // Получаем массив подкюченных модулей рекурсивно
            calcFilesPathArray: function (files) {
                // Читаем каждый файл
                var file = opt.fs.readFileSync(files, opt.encoding);
                // Разбиваем файл на массив строк по символу переноса строки
                var strings = file.split('\n');
                strings.forEach(function (item, i, arr) {
                    // Завершаем итерацию, если нет инклуда
                    var testInclude = item.indexOf(htmlParser.options.inc);
                    if (testInclude < 0) {
                        return false;
                    }
                    // Завершаем итерацию, если строка закоментирована перед include
                    var testComment = item.indexOf('//');
                    if (testComment > -1 && testInclude > testComment) {
                        return false;
                    }
                    // Удаляем со строки пробелы, табуляцию
                    var clearPath = item.replace(/\s/g, '');
                    // Удаляем имя файла
                    clearPath = clearPath.substring(0, clearPath.lastIndexOf('/') + 1);
                    // Из локального пути убираем include
                    clearPath = clearPath.replace(htmlParser.options.inc, '');
                    // В локальный путь прописываем полный путь к файлу
                    clearPath = files.substring(0, files.lastIndexOf('/') + 1) + clearPath;
                    // Из локального пути убираем множество ../../
                    clearPath = htmlParser.deletePoints(clearPath);
                    // Завершаем итерацию, если значение есть в массиве
                    if (htmlParser.options.components.indexOf(clearPath) > -1) {
                        return false;
                    }
                    // Пушим значение в массив
                    htmlParser.options.components.push(clearPath);
                    // Получившийися путь к компоненту проходим на уровень глубже
                    htmlParser.calcFilesPathArray(clearPath + opt.name.jade);
                });
            },

            // Берем список файлов в папке рекурсивно
            getFiles: function (path) {
                var files = opt.fs.readdirSync(path);
                files.forEach(function (item, i, arr) {
                    var newPath = path + item;
                    if (opt.doesDir(newPath)) {
                        htmlParser.getFiles(newPath + '/');
                    } else {
                        htmlParser.calcFilesPathArray(newPath);
                    }
                });
            },

            // Инициализация приложения
            init: function() {
                // Задаем начальные параметры
                this.options = {
                    // пути к папкам со страницами
                    src: ['./src/pages/proj/', './src/pages/tpl/'/*, './src/pages/_demo/'*/],
                    inc: 'include',// имя для include
                    components: []// Создаем пустой массив подключенных компонентов
                };

                // Собираем массив подключенных модулей, удаляя дубли
                this.options.src.forEach(function (item, i, arr) {
                    htmlParser.getFiles(item);
                });

                // Пишем список модулей в глобальный объект
                opt.modules = htmlParser.options.components;
                // console.log(opt.modules);
            }
        };

        // вызов приложения
        htmlParser.init();
    });
};