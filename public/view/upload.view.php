<div class="field">
<label class="label">Image</label>
<div class='card-image'>
    <figure class='image is-3by3'>
        <video></video>
        <img style="display: none;" id="my-image-crop-view"/>
        <img style="display: none;" id="finalImageRes"/>
    </figure>
</div>
<div class="field is-grouped">
    <div class="control">
        <button class="button is-link" disabled id="snapshot">Take a photo</button>
        <button class="button is-link" id="crop-button" style="display: none;">Crop</button>
        <button class="button is-link" id="retake" style="display: none;">Retake</button>
    </div>
</div>

</div>

<input type="file" style="display: none;" id="tmpFile" />

<div class="field">
</div>
<div class="field">
    <label class="label">Message</label>
    <div class="control">
        <textarea class="textarea" placeholder="Textarea"></textarea>
    </div>
</div>
<div class="field is-grouped">
    <div class="control">
        <button class="button is-link" id="submit">Submit</button>
    </div>
</div>


<script src="/js/upload.js"></script>
