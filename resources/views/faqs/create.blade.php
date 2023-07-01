<x-app-layout>
    <div class="page">
        @if ($errors->any())
            <div class="alert alert-danger fade show" role="alert">
                Please fill in the mandatory fields
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="header" id="buttons-to-top">
            <div class="pull-left mb-2">
                <h2>
                    Create a FAQ
                </h2>
            </div>
            <div class="pull-right flex" href="{{ route('faqs.create') }}">
                <button type="submit" id="save-button" disabled form="faq-form" class="flex btn btn-success" href="">
                    Save
                </button>
            </div>
            <div class="clear-both"></div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-12">
                <div class="card">
                    <form id="faq-form" method="POST" action="{{ route('faqs.store') }}" class="row g-3">
                        @csrf
                        <div class="col-md-12">
                            <label for="inputQuestion" class="form-label">Question</label>
                            <input type="text" value="{{ old('question') }}" name="question" class="form-control"
                                id="inputQuestion">
                            @error('question')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="inputAnswer" class="form-label">Answer</label>
                            <textarea name="answer" id="inputAnswer" class="form-control" cols="30"
                                rows="10">{{ old('answer') }}</textarea>
                            @error('answer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
