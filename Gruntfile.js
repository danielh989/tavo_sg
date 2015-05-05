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
        dest: 'assets/js/built.js',
      },
    },
    uglify: {
      js: {
        files: {
          'assets/js/tavo.min.js': ['assets/js/built.js']
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-stylus');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');

};