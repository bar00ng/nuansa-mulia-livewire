<div>
    <x-page-header pageName="Project" />

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="m-0 font-weight-bold text-primary">Edit Todo</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateTodo">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select wire:model="status" id="status" class="form-select">
                                <option value="todo">Todo</option>
                                <option value="progress">Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
