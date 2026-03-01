const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;
const { BlockControls, Toolbar } = wp.blockEditor;
const { IconButton } = wp.components;

function addToolbarControls(editProps) {
    const { isSelected } = editProps;
    if (!isSelected) return null;

    return (
        <Fragment>
            <BlockControls>
                <Toolbar>
                    <IconButton
                        icon="edit"
                        label="Edit"
                        onClick={() => {
                            // Add your custom edit function here
                            alert('Edit button clicked!');
                        }}
                    />
                    <IconButton
                        icon="saved"
                        label="Save"
                        onClick={() => {
                            // Add your custom save function here
                            alert('Save button clicked!');
                        }}
                    />
                </Toolbar>
            </BlockControls>
        </Fragment>
    );
}

registerBlockType('your-namespace/your-block-name', {
    

    edit(props) {
        return [
            addToolbarControls(props)
        ];
    },

    save() {
        return null; 
    }
});
