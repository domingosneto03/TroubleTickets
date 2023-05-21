const addTagInput = document.getElementById('tag_input');
const addTagButton = document.getElementById('tag_adder');
const tagsContainer = document.getElementById('tag_container');

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

tagsContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('x_button')) {
        removeTag(event);
    }
});

addTagInput.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        addTag();
    }
});

addTagButton.addEventListener('click', function(event) {
    addTag();
});

function addTag() {
    const ticketId = addTagButton.dataset.ticket;
    const tag = addTagInput.value.trim();

    if (tag !== '') {
        const data = {
            ticketId: ticketId,
            tag: tag
        };

        fetch('actions/action_add_hashtag.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: encodeForAjax(data),
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const tagElement = document.createElement('div');
                tagElement.id = 'tag_' + result.tagId;
                const tagName = document.createElement('a');
                tagName.href = "";
                tagName.classList.add('ticket_tag');
                tagName.innerText = tag;
                const tagButton = document.createElement('button');
                tagButton.classList.add('x_button');
                tagButton.dataset.ticket = ticketId;
                tagButton.dataset.tag = result.tagId;
                tagButton.innerText = 'x';
                tagElement.appendChild(tagName);
                tagElement.appendChild(tagButton);
                tagsContainer.insertBefore(tagElement, addTagInput);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

function removeTag(event) {
    const ticketId = event.target.dataset.ticket;
    const tagId = event.target.dataset.tag;

    const data = {
        ticketId: ticketId,
        tagId: tagId
    };

    fetch('actions/action_remove_hashtag.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: encodeForAjax(data),
    })
        .then(response => response.json())
        .then(result => {
        if (result.success) {
            const tagElement = document.getElementById('tag_' + tagId);
            if (tagElement) {
                tagElement.remove();
            } 
        } else {
            alert(result.message);
        }
        })
        .catch((error) => {
        console.error('Error:', error);
    });
}