<x-app-layout>
    <div class="page">
        @if (session('status'))
            <div class="alert alert-success fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger fade show" role="alert">
                Please fill in the mandatory fields
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="header" id="buttons-to-top">
            <div class="pull-left mb-2">
                <h2>
                    Faq {{ $faq->id }}
                </h2>
            </div>
            <div class="pull-right flex" href="{{ route('faqs.create') }}">
                <button disabled id="save-button" type="submit" form="faq-form" class="flex btn btn-success" href="">
                    Save
                </button>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-9">
                <div class="card">
                    <form id="faq-form" method="POST" action="{{ route('faqs.update', $faq->id) }}"
                        class="row g-3">
                        @csrf
                        @method('put')
                        <div class="col-md-12">
                            <label for="inputFirstName" class="form-label">Question</label>
                            <input type="text" value="{{ old('question', $faq->question) }}" name="question"
                                class="form-control" id="inputFirstName">
                            @error('question')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="inputAnswer" class="form-label">Answer</label>
                            <textarea name="answer" id="inputAnswer" class="form-control" cols="30" rows="10"
                                >{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <h3>Information</h3>
                    <div class="update-by">
                        <span>Last Update</span>
                        <span>{{ \Carbon\Carbon::parse($faq->updated_at)->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="card delete-card mt-5">
                    <button class="transparent-btn text-danger flex" type="button" data-bs-toggle="modal"
                        data-bs-target="#modal-{{ $faq->id }}">
                        <svg style="margin-right: 1rem" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                        </svg>
                        Delete this entry
                    </button>
                </div>
            </div>
        </div>
        @include('components.modal', [
            'id' => 'modal-' . $faq->id . '',
            'route' => route('faqs.delete', $faq->id),
            'message' => 'Are you sure you want to delete this entry?',
        ])
    </div>
</x-app-layout>
