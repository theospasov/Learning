// this function is default to WP. wp lives in the global scope and block. when we load the Block editor.
wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: 'Are You Paying Attention?',
    icon: 'smiley',
    category: 'common',
    edit: function() { // what we see in the Editor 
        return wp.element.createElement('h3', null, 'Hello, this is from the admin editor') // official WP way of creating an HTML element within JS
    },
    save: function() { // what the public sees 
        return wp.element.createElement('h1', null, 'This is the frontend')
    }
}) 