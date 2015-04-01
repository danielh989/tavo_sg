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
    },
  });

  grunt.loadNpmTasks('grunt-contrib-stylus');
  grunt.loadNpmTasks('grunt-contrib-watch');

};