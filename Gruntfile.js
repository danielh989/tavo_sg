module.exports = function(grunt) {

  grunt.initConfig({
    stylus: {
      compile: {
        files: {
          'assets/css/style.css': 'assets/css/src/*.styl',
        }
      }
    },
    watch: {
      stylus: {
        files: ['assets/css/src/*.styl'],
        tasks: ['stylus']
      },
      scripts: {
        files: ['assets/js/src/*.js'],
        tasks: ['concat', 'uglify']
      }
    },
    concat: {
      dist: {
        src: ['assets/js/src/*.js'],
        dest: 'assets/js/builts/built.js',
      },
      base: {
        src: ['assets/js/base/*.js', 'node_modules/mustache/mustache.js'],
        dest: 'assets/js/builts/base.js'
      }
    },
    uglify: {
      js: {
        files: {
          'assets/js/tavo.min.js': ['assets/js/builts/built.js'],
          'assets/js/base.min.js': ['assets/js/builts/base.js']
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-stylus');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');

};