module.exports = {
    dist: {
        options: {
            sourcemap: 'none',
            trace: 'true',
            style: 'compressed'
            //style: 'expanded'
        },
        files: {
            'src/assets/css/a.css': 'src/assets/scss/main.scss'
        }
    }
}
