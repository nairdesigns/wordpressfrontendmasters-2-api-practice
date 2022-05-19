(function () {

    (function init() {

        newPostBtn.addEventListener( 'click', togglePostForm );
        savePostBtn.addEventListener( 'click', savePost );

        loadPosts();

    })();

    function loadEditForm( event ) {

        let title = event.target.parentElement.querySelector( '.entry-title a' ).innerText,
            content = event.target.parentElement.querySelector( '.entry-content' ).innerHTML,
            id = event.target.parentElement.dataset.id;

        event.preventDefault();
        togglePostForm();

        // Change TITLE_HERE to title
        // Change CONTENT_HERE to content
        // Change ID_HERE to id
        formTitle.value = TITLE_HERE;
        tinyMCE.activeEditor.setContent( CONTENT_HERE );
        savePostBtn.dataset.id = ID_HERE;

    }

    function savePost( event ) {

        const newPost = {
            'title': formTitle.value,
            'content': tinyMCE.activeEditor.getContent(),
            'status': 'publish'
        };
        let post = new wp.api.models.Post( newPost ),
            postId = savePostBtn.dataset.id,
            currentPost = {};

        // Change POST_ID_OBJECT to { id: postId }
        if ( '' !== postId ) {
            currentPost = POST_ID_OBJECT;
        }

        event.preventDefault();
        togglePostForm();

        // Change CURRENT_POST_HERE to currentPost
        post.save( CURRENT_POST_HERE )
            .done( () => {
                loadMessage( 'saved' );
                clearForm();
                loadPosts();
            } );

    }

    function loadPosts() {

        let posts = new wp.api.collections.Posts();

        posts.fetch( {
                data: {
                    per_page: 3,
                }
            } )
            .done( () => {
                clearPosts();
                posts.each( post => {
                    loadPost( post.attributes );
                } );
            } );

    }

    function loadPost( post ) {

        const article = document.createElement( 'article' );
        let markup = '';

        markup += `<h2 class="entry-title"><a href="${post.link}">${post.title.rendered}</a></h2>`;
        markup += `<div class="entry-content">${post.content.rendered}</div>`;
        article.classList.add( 'post' );
        article.dataset.id = post.id;
        article.innerHTML = markup;
        // Set LOGGED_IN to jsforwp_vars.logged_in
        if ( true == LOGGED_IN ) {
            article.append( getEditLink() );
        }
        appContainer.append( article );

    }

    function getEditLink() {

        let link = document.createElement( 'a' );

        link.href = '#edit-post';
        link.innerText = 'Edit';

        // Change LOAD_FORM_FUNCTION to loadEditForm
        link.addEventListener( 'click', LOAD_FORM_FUNCTION );

        return link;

    }


})();
