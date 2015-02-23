module.exports = {
  dist: {
    options: {
      // cssmin will minify later
      style: 'expanded'
    },
    files: {
      'dev/assets/css/app.css': 'dev/assets/sass/app.scss'
    }
  }
}
