console.log('notes');

let editModal = document.getElementById('editModal');
let showModal = document.getElementById('showModal');


//to open the modal while clicking to edit button.
function buttonEditModal(element) {
    //to change the display of modal from none to flex
    editModal.style.display = 'flex';

    //get the parent node of button to get the title and note.
    let note = element.parentNode.parentNode.childNodes;
    // console.log(note);
    // console.log('Title=>', note[1].innerText, '\nNote=>', note[5].innerHTML)
    editModal.innerHTML = `
                            <div class="edit-box">
                                <form action="notes.php" method="POST">
                                    <input type="text" name="title" placeholder="Title" value=${note[1].innerText}>
                                    <textarea name="note" rows="10"  placeholder="Take a note...">${note[5].innerHTML}</textarea>
                                    <input type="hidden" name="note_id" value=${note[7].value}>
                                    <button type="submit" name="update" value="update">Update</button>
                                </form> 
                                <div class="edit-modal-close" id="closeModal">
                                    +
                                </div>                               
                            </div> `


    //To close the Modal                        
    document.getElementById('closeModal').addEventListener('click', () => {
        editModal.style.display = 'none';
    });
}




function buttonShowModal(element) {
    // console.log(element);
    //to change the display of modal from none to flex
    showModal.style.display = 'flex';

    //get the parent node of button to get the title and note.
    let note = element.parentNode.parentNode.childNodes;
    // console.log('Paragraph',note[5].innerHTML);
    showModal.innerHTML = `
                            <div class="show-box">
                                <h2>${note[1].innerHTML}</h2>
                                <hr>
                                <p>${note[5].innerHTML}</p>
                                <div class="show-modal-close" id="showModal">
                                    +
                                </div>                               
                            </div> `


    //To close the Modal                        
    document.getElementById('showModal').addEventListener('click', () => {
        showModal.style.display = 'none';
    });
}