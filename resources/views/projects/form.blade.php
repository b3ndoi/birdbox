
    <div class="field">
        <label for="" class="label">Title</label>
        <div class="control">
            <input type="text" name="title" value="{{$project->title}}" class="input">
        </div>
    </div>

    <div class="field">
        <label for="" class="label">Description</label>
        <div class="control">
            <textarea type="text" name="description" class="textarea">{{$project->description}}</textarea>
        </div>
    </div>
    <!-- <div class="field">
        <label for="" class="label">Notes</label>
        <div class="control">
            <textarea type="text" name="notes" class="textarea">{{$project->notes}}</textarea>
        </div>
    </div> -->

    <div class="field">
        <div class="control">
            <button class="button is-link">{{$submit}}</button>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <a href="{{$project->path()}}" class="is-link">Cancel</a>
        </div>
    </div>