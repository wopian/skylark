module.exports = {
    dist: {
        options: {
            sourcemap: 'none',
            style: 'compressed'
            //style: 'expanded'
        },
        files: {
            'src/assets/css/a.css': 'src/assets/scss/main.scss'
        }
    }
}
