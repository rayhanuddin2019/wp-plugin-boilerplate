/**
 * WordPress Dependencies
 */
 const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );
 const path = require( 'path' );

 defaultConfig.output.chunkLoadingGlobal = defaultConfig.jsonpFunction
 
 delete defaultConfig.output.jsonpFunction
 
 module.exports = {
         ...defaultConfig,
         ...{
            entry: {
                block: path.resolve( process.cwd(), 'src', 'block.js' ),
                style: path.resolve( process.cwd(), 'src', 'style.css' ),
             
                editor: path.resolve( process.cwd(), 'src', 'editor.css' ),
                dashboard: path.resolve( process.cwd(), 'src', 'dashboard.js' ),
                frontend: path.resolve( process.cwd(), 'src', 'frontend.js' )
            }
            
         }
        
 }