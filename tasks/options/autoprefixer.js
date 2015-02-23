module.exports = {
  options: {
    browsers: ['last 2 version']
  },
  multiple_files: {
    expand: true,
    flatten: true,
    src: 'dev/assets/css/*.css',
    dest: 'dev/assets/css/'
  }
}
