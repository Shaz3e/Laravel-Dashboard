@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mail Settings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item active">Mail Settings</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Update Email Settings -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Email Settings</h3>
                </div>
                <form action="{{ route('admin.mail-settings.post.data') }}" method="POST" id="submitForm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="smtp_host">SMTP Host</label>
                                    <input type="text" name="smtp_host" class="form-control" id="smtp_host"
                                        value="{{ $dataSet['smtp_host'] == null ? config('mail.mailers.smtp.host') : $dataSet['smtp_host'] }}"
                                        maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="smtp_email">SMTP Email</label>
                                    <input type="email" name="smtp_email" class="form-control" id="smtp_email"
                                        value="{{ old('smtp_email', $dataSet['smtp_email'] == null ? config('mail.mailers.smtp.username') : $dataSet['smtp_email']) }}"
                                        email="true" maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="smtp_password">SMTP Password</label>
                                    <input type="text" name="smtp_password" class="form-control" id="smtp_password"
                                        value="{{ old('smtp_password', $dataSet['smtp_password'] == null ? config('mail.mailers.smtp.password') : $dataSet['smtp_password']) }}"
                                        minlength="8" maxlength="64" required />
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="smtp_port">SMTP Port</label>
                                    <input type="text" name="smtp_port" class="form-control" id="smtp_port"
                                        value="{{ old('smtp_port', $dataSet['smtp_port'] == null ? config('mail.mailers.smtp.port') : $dataSet['smtp_port']) }}"
                                        number="true" minlength="2" maxlength="6" required />
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="smtp_secure">SMTP Secure</label>
                                    <select name="smtp_secure" class="form-control" id="smtp_secure">
                                        <option value="tls" {{ config('mail.mailers.smtp.encryption') == 'tls' ? 'selected' : '' }}>
                                            Secure
                                            TLS
                                        </option>
                                        <option value="ssl" {{ config('mail.mailers.smtp.encryption') == 'ssl' ? 'selected' : '' }}>
                                            Secure
                                            SSL
                                        </option>
                                        <option value="null" {{ config('mail.mailers.smtp.encryption') == null ? 'selected' : '' }}>
                                            Non-SSL
                                            Settings</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="from_name">From Name</label>
                                    <input type="text" name="from_name" class="form-control" id="from_name"
                                        value="{{ old('from_name', $dataSet['from_name'] == null ? config('mail.from.name') : $dataSet['from_name']) }}"
                                        maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="from_email">From Email</label>
                                    <input type="email" name="from_email" class="form-control" id="from_email"
                                        value="{{ old('from_email', $dataSet['from_email'] == null ? config('mail.from.address') : $dataSet['from_email']) }}"
                                        email="true" maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="to_email">To Email</label>
                                    <input type="email" name="to_email" class="form-control" id="to_email"
                                        value="{{ old('to_email', $dataSet['to_email'] == null ? config('mail.from.address') : $dataSet['to_email']) }}"
                                        email="true" maxlength="255" required />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="bcc_email">BCC Email</label>
                                    <input type="email" name="bcc_email" class="form-control" id="bcc_email"
                                        value="{{ old('bcc_email', $dataSet['bcc_email'] == null ? config('mail.from.address') : $dataSet['bcc_email']) }}"
                                        email="true" maxlength="255" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        {{-- <button type="button" class="ml-2 btn btn-success">Send Test Mail</button> --}}
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Update Email Settings -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        $('#submitForm').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@endsection
