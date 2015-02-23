module.exports = {
  dynamic: {
    files: [{
      expand: true,
      cwd: 'dev/assets/images/',
      src: ['**/*.{png,jpg,gif}'],
      dest: 'app/assets/images/'
    }]
  }
}
