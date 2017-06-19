/*
1. Go to project directory
2. Import this template into project directory as gruntfile.js
3. Create package.json
npm init

4. Install Grunt in project
npm install grunt --save-dev

5. Install Plugins
// Minimize JS: 
npm install grunt-contrib-uglify --save-dev
// Compile Sass:
npm install grunt-sass --save-dev
// Image Optimizer
npm install grunt-contrib-imagemin --save-dev
// Watch for file changes:
npm install grunt-contrib-watch --save-dev
// Browser Sync
npm install grunt-browser-sync --save-dev
// Post CSS
npm install  grunt-postcss --save-dev
// Autoprefixer
npm install autoprefixer --save-dev

6. Configure the MAMP Config Section below
7. This template is configured for the above plugins. Command Line Grunt commands:
	Grunt: 	Watches for changes to Sass & JS, compiling both into readable format & refreshes browser
	Grunt Build: 	Final compile of Sass, css prefixes, JS, and images
*/

module.exports = function(grunt) {
/*
	// Mamp Config Variables
	//var user = 'yourUsername'
	var path = '../../../';   			// If in wordpress theme dir use '../../../'
	var pathRelative = true;
	var port = 80;
*/

// Configure task(s)
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

// Uglify JS
		uglify: {
			build: {										// Build Option: Compressed JS				
				src: 'src/js/*.js',
				dest: 'js/script.min.js'
			},
			dev: {										// Dev option: Expanded JS
				options: {
					beautify: true,
					mangle: false,
					compress: false,
					preserveComments: 'all'
				},
				src: 'src/js/*.js',
				dest: 'js/script.min.js'
			}
		},

// Sass Compiler
		sass: {
			build: {										// Build Option: Compressed CSS
				options: {
					outputStyle: 'compressed'
				},
				files: {
					'css/style.css' : 'src/scss/application.scss'
				}		
			},
			dev: {										// Dev option: Expanded CSS
				options: {
					outputStyle: 'expanded'
				},
				files: {
					'css/style.css' : 'src/scss/application.scss'
				}
			}
		},

// // Image Optimizer
// 		imagemin: {
// 			dynamic: {
// 				files: [{
// 					expand: true,
// 					cwd: 'img/',
// 					src: ['**/*.{png,jpg,gif}'],
// 					dest: 'img/'
// 				}]
// 			}
// 		},		

// Watch
		watch: {
			options: {
				livereload: true,				// Turn on live reloading of browser
			},
			js: {												// Watch for changes to JS files
				files: ['src/js/*.js'],
				tasks: ['uglify:dev']			// Run Ugify Dev Instance
			}, 
			css: {											// Watch for changes to .css files
				files: ['src/scss/**/*.scss'],
				tasks: ['sass:dev']			// Run Sass Dev Instance
			},
			html: {										// Watch for changes to .html files
				files: ['*.html']	
			},
			php: {										// Watch for changes to .php files
				files: ['*.php', 'inc/*.php', 'includes/*.php']
			},
		},

// // Browser Sync
//         browserSync: {
//             bsFiles: {
//                 src : ['css/*.css', '*.html']
//             },
//             options: {
//                 watchTask: true,
//                 server: {
//                     baseDir: "./"
//                 }
//             }
//         },  



// Post CSS
        // postcss: {
        //   options: {
        //     map: true,
        //     processors: [
        //       require('autoprefixer')({browsers: ['last 10 versions', 'ie 10']})
        //     ]
        //   },
        //   dist: {
        //     src: 'css/main.css'
        //   }
        // }   
    
	});

	//Load plugins
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-sass');
	//grunt.loadNpmTasks('grunt-contrib-imagemin');  
	grunt.loadNpmTasks('grunt-contrib-watch');
	//grunt.loadNpmTasks('grunt-browser-sync');
	//grunt.loadNpmTasks('grunt-mamp');
	//grunt.loadNpmTasks('grunt-postcss');
	//grunt.loadNpmTasks('autoprefixer');


	//Register tasks(s)
		//Dev Option (grunt)
		grunt.registerTask('default', ['watch']);
		//Build option (grunt build)
		grunt.registerTask('build', ['imagemin','uglify:build', 'sass:build']);

/*
		// Mamp
		grunt.registerTask("start", ["mamp:startserver"]);
		grunt.registerTask("stop", ["mamp:stopserver"]);
		grunt.registerTask("config", ["mamp:configserver"]);
*/
};