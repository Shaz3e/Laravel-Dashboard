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
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ DiligentCreators('dashboard_url') }}">Home</a></li>
                            <li class="breadcrumb-item active">Agent Account</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        @if ($agent_account == null)
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="alert alert-danger">
                        You are not an IB.
                    </div>
                    <a class="btn btn-lg btn-block btn-flat btn-primary btn-theme" href="/#introducing-broker">Visit
                        Dashboard to Become an IB</a>

                </div>
                {{-- /.container-fluid --}}
            </section>
            <!-- /.content -->
        @else
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title my-1">Change Agent Account Password</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        {{-- ./card-header --}}
                        <form action="{{ route('profile.update.agent.account') }}" method="POST"
                            id="submitFormAgentAccount">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="agent_account_number">Account Number</label>
                                            <input type="text" name="agent_account_number" class="form-control"
                                                value="{{ $agent_account }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <label for="password">Change Password</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="password" id="password"
                                                value="{{ old('password') }}" minlength="8" maxlength="12" required />
                                            <div class="input-group-append">
                                                <button type="button" name="security" id="generatePasswordBtn"
                                                    class="btn btn-primary btn-theme input-group-text">Generate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- /.row --}}
                            </div>
                            {{-- /.card-body --}}
                            <div class="card-footer">
                                <button type="submit" name="changeAgentAccountPassword"
                                    class="btn btn-flat btn-theme">Chane Password</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                {{-- /.container-fluid --}}
            </section>
            <!-- /.content -->
        @endif
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <script>
        // generate random password
        function generatePassword() {
            let alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            let numbers = "0123456789";
            let specialCharacters = "!@#$%";

            // Generate one character of each type
            let password = '';
            password += alphabet.charAt(Math.floor(Math.random() * alphabet.length));
            password += numbers.charAt(Math.floor(Math.random() * numbers.length));
            password += specialCharacters.charAt(Math.floor(Math.random() * specialCharacters.length));

            // Generate the remaining characters
            for (let i = 0; i < 5; i++) {
                let randomType = Math.floor(Math.random() * 2); // 0 for alphabet, 1 for number
                switch (randomType) {
                    case 0:
                        password += alphabet.charAt(Math.floor(Math.random() * alphabet.length));
                        break;
                    case 1:
                        password += numbers.charAt(Math.floor(Math.random() * numbers.length));
                        break;
                }
            }

            // Shuffle the password characters to ensure randomness
            password = shuffleString(password);

            return password;
        }

        $('#generatePasswordBtn').click(function(e) {
            let password = generatePassword();
            $("#password").val(password);
        });

        // Function to shuffle a string
        function shuffleString(str) {
            let shuffled = str.split('').sort(function() {
                return 0.5 - Math.random();
            }).join('');
            return shuffled;
        }
    </script>
@endsection
