/**
 * WordPress dependencies
 * Seo Tools
 */

 const { __ } = wp.i18n;
 const { registerBlockType } = wp.blocks;

 
 registerBlockType( 'mangocube/word-wrapper', {
     title: __( 'Word Wrapper Tools' ),
 
     description: __( 'Seo Tools Word.' ),
 
     keywords: [
         __( 'word wrapper' ),
         __( 'tools' ),
         __( 'word' ),
     ],
 
     supports: {
         align: [ 'wide', 'full' ],
         anchor: true,
         html: false,
     },
 
     category: 'common',
 
     icon: 'editor-kitchensink',
 
     attributes: {
         block_id: {
             type: 'string',
         },
     },
 
     edit: ( props ) => {
         const { className, block_id } = props;
 
         return (
             <div className={ className }>
                <h2> Word Tools </h2>
          
             </div>
         );
     },
 
     save: ( props ) => {
         const { className, block_id } = props;
 
         return (
             <div data-id={className} className={ className }>
                <h2> Word Tools </h2>
             </div>
         );
     },
 } );