import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from '@wordpress/components'

import "./index.scss"

// this function is default to WP. wp lives in the global scope and block. when we load the Block editor.
wp.blocks.registerBlockType('ourplugin/are-you-paying-attention', {
    title: 'Are You Paying Attention?',
    icon: 'smiley',
    category: 'common',
    attributes: {
        question: {type: "string"},
        answers: {type: 'array', default: ['red', 'blue']}
    },
    edit: EditComponent,
    save: function(props) { // what the public sees 
        return null
    }
}) 

function EditComponent(props) { // what we see in the Editor 

    function updateQuestion(value) {
        props.setAttributes({question: value})
    }

    function deleteAnswer(indexToDelete) {
        const newAnswers = props.attributes.answers.filter(function(x, index) {
            return index != indexToDelete
        })
        props.setAttributes({answers: newAnswers})
    }

    return (
        <div className='paying-attention-edit-block'>
            <TextControl label="Question:" value={props.attributes.question} onChange={updateQuestion} style={{fontSize: '20px'}}></TextControl>
            <p style={{fontSize: '13px', margin: '20px 0 8px 0'}}>Answers:</p>
            {props.attributes.answers.map(function(answer, index) {
                return (
                <Flex>
                    <FlexBlock>
                        <TextControl value={answer} onChange={newValue => {
                            const newAnswers = props.attributes.answers.concat([])
                            newAnswers[index] = newValue
                            props.setAttributes({answers: newAnswers})
                        }} />
                    </FlexBlock>
                    <FlexItem>
                        <Button>
                            <Icon className="mark-as-correct" icon="star-empty" />
                        </Button>
                    </FlexItem>
                    <FlexItem>
                        <Button isLink className='attention-delete' onClick={() => deleteAnswer(index)} >Delete</Button>
                    </FlexItem>
                </Flex>
                )
            })}
            <Button variant="primary" onClick={() => {
                props.setAttributes({answers: props.attributes.answers.concat([''])})
            }}>Add another answer</Button>


            {/* <input type="text" placeholder="sky color" onChange={updateSkyColor} value={props.attributes.skyColor}/>
            <input type="text" placeholder="grass color" onChange={updateGrassColor} value={props.attributes.grassColor}/> */}
        </div>
    )
}