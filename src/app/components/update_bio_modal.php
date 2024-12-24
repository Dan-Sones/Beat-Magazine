<?php if (isset($user)) : ?>
    <div class="modal" tabindex="-1" id="bioEditorModal">
        <div class="modal-dialog">
            <form id="bioEditorForm" onsubmit="updateBio(event, <?php echo $user->getId() ?>) ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5">Bio Editor</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newBioText" class="form-label">New Bio</label>
                            <textarea class="form-control" id="newBioText" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Bio</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        <?php if (isset($journalistBio)): ?>
        let journalistBio = <?= json_encode($journalistBio) ?>;
        <?php else: ?>
        let journalistBio = '';
        <?php endif; ?>
    </script>

    <script src="/js/updateBioModal.js"></script>

<?php endif; ?>


