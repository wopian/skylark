var timer = require("grunt-timer");

module.exports = function(grunt) {

  timer.init(grunt, { deferLogs: true, friendlyTime: true });

  function loadConfig(path) {
    var glob = require('glob');
    var object = {};
    var key;

    glob.sync('*', {cwd: path}).forEach(function(option) {
      key = option.replace(/\.js$/,'');
      object[key] = require(path + option);
    });

    return object;
  };

  var config = { pkg: grunt.file.readJSON('package.json') };

  grunt.loadTasks('tasks');
  grunt.util._.extend(config, loadConfig('./tasks/'));
  grunt.initConfig(config);

  require('load-grunt-tasks')(grunt);

  grunt.registerTask('default', ['phpanalyzer', 'sass', 'autoprefixer', 'cssmin', 'htmlmin', 'copy', 'imagemin']);

};

// Package.json
// "grunt-contrib-uglify": "^0.9.2",
// "grunt-contrib-concat": "^0.5.1",
// "grunt-contrib-jshint": "^0.11.3",
