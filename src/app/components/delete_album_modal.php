<?php if (isset($album)): ?>
    <div class="modal" tabindex="-1" id="deleteAlbumModal">
        <div class="modal-dialog">
            <form onsubmit="deleteAlbum(event, <?= $album->getAlbumID() ?>)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">With great power comes great responsibility...</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this Album? It will delete all User & Journalist Reviews
                            along
                            with
                            it</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Album (Destructive!!)</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="/js/deleteAlbumModal.js"></script>
<?php endif; ?>