<x-app-layout>
    <div class="page">
        <div class="header">
            <div class="pull-left">
                <h2>FAQ {{ $faq->id }}</h2>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <h3 class="card-header mt-0">
                        Main Information
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="label-field">
                                    <strong>FAQ ID: </strong>
                                  </div>
                                  <span>
                                      {{ $faq->id }}
                                  </span>
                                <div class="label-field">
                                    <strong>
                                        Question:
                                    </strong>
                                </div>
                                <span>
                                    {{ $faq->question }}
                                </span>

                                <div class="label-field">
                                    <strong>
                                        Answer
                                    </strong>
                                </div>
                                <span>
                                    {{ $faq->answer }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
