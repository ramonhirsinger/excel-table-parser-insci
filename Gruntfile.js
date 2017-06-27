module.exports = function (grunt) {
    grunt.initConfig({

        pkg: grunt.file.readJSON("package.json"),

        paths: {
            src: {
                concat: 'script/*.js',
                script: 'script/script.js',
                jquery: 'jquery-3.2.1/jquery-3.2.1.min.js',
                scss: 'scss/style.scss',
                image: '../../'
            },
            dest: {
                concat: 'js/main.js',
                concatmin: 'js/main.min.js',
                jstargz: 'js/main.min.js.gz',
                csstargz: 'css/main.min.css.gz',
                css: 'css/main.min.css',
                image: '../../compressed'
            }
        },
        concat: {
            js: {
                options: {
                    separator: ';'
                },
                src: ['script/jquery-3.2.1/jquery-3.2.1.min.js','plugin/bootstrap/js/bootstrap.min.js',
                      'plugin/selectric/js/jquery.selectric.js','plugin/selectric/js/jquery.selectric.placeholder.min.js',
                      'script/*.js'],
                dest: '<%= paths.dest.concat %>'
            }
        },
        uglify: {
            files: {
                src: '<%= paths.dest.concat %>',
                dest: '<%= paths.dest.concatmin %>'
            }
        },
        compress: {
            files: {
                src: '<%= paths.dest.concatmin %>',
                dest: '<%= paths.dest.jstargz %>'
            }
        },
        sass: {
            dist: {
                options: {
                    style: 'compressed'
                },
                files: {
                    '<%= paths.dest.css %>': '<%= paths.src.scss %>'
                }
            }
        },
        cssmin: {
            options: {
                mergeIntoShorthands: false,
                roundingPrecision: -1,
                report: 'gzip'
            },
            target: {
                files: {
                    '<%= paths.dest.csstargz %>': '<%= paths.dest.css %>'
                }
            }
        },
        imagemin: {
            dynamic: {
                options: {
                    optimizationLevel: 3,
                },
                files: [{
                        expand: true,
                        cwd: '<%= paths.src.image %>',
                        src: ['**/*.{png,jpg,gif}'],
                        dest: '<%= paths.dest.image %>'
                    }]
            }
        },
        watch: {
            css: {
                files: ['<%= paths.src.scss %>'],
                tasks: ['sass:dist', 'cssmin']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('image', ['imagemin']);

    grunt.registerTask('css', ['sass:dist', 'cssmin']);

    grunt.registerTask('js', ['concat']);
};