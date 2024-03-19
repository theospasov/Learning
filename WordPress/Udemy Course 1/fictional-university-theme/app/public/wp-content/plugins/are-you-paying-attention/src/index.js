import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from '@wordpress/components'

import "./index.scss"

// this function is default to WP. wp lives in the global scope and block. when we load the Block editor.
wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: 'Are You Paying Attention?',
    icon: 'smiley',
    category: 'common',
    attributes: {
        skyColor: {type: "string"},
        grassColor: {type: "string"}
    },
    edit: EditComponent,
    save: function(props) { // what the public sees 
        return null
    }
}) 

function EditComponent(props) { // what we see in the Editor 
    function updateSkyColor(e) {
        props.setAttributes({skyColor: e.target.value})
    }

    function updateGrassColor(e) {
        props.setAttributes({grassColor: e.target.value})
    }


    return (
        <div className='paying-attention-edit-block'>
            <TextControl label="Question:"></TextControl>
            <p>Answers:</p>
            <Flex>
                <FlexBlock>
                    <TextControl/>
                </FlexBlock>
                <FlexItem>
                    <Button>
                        <Icon icon="star-empty" />
                    </Button>
                </FlexItem>
                <FlexItem>
                    <Button>Delete</Button>
                </FlexItem>
            </Flex>


            {/* <input type="text" placeholder="sky color" onChange={updateSkyColor} value={props.attributes.skyColor}/>
            <input type="text" placeholder="grass color" onChange={updateGrassColor} value={props.attributes.grassColor}/> */}
        </div>
    )
}