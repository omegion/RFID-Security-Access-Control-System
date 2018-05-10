@extends('layouts.app')

@section('styles')
<style>
    .all-wrapper {
        padding-top: 10% !important;
        -webkit-box-shadow: 0px 0px 40px rgba(0,0,0,0);
        box-shadow: 0px 0px 40px rgba(0,0,0,0);
    }
    .logo-icon i{
        color: #427bf9;
        font-size: 52px;
    }
    .logo-icon-red i{
        color: #f93e3e;
        font-size: 52px;
    }
    .fade-enter-active, .fade-leave-active {
    transition: opacity .3s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    }
    .loading-icon {
            -webkit-animation: rotation 2s infinite linear;
    }
    [v-cloak] {display: none}

    @-webkit-keyframes rotation {
            from {
                    -webkit-transform: rotate(0deg);
            }
            to {
                    -webkit-transform: rotate(359deg);
            }
    }
</style>
@append
@section('content')

<body class="auth-wrapper">
    <div class="all-wrapper menu-side">
        <div class="row">
            <div class="col-sm-5 offset-sm-1">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="user-profile compact">
                            <div class="up-head-w" style="background-image:url(https://source.unsplash.com/random)">
                                <div class="up-social"><a href="#"><i class="os-icon os-icon-twitter"></i></a><a href="#"><i class="os-icon os-icon-facebook"></i></a></div>
                                <div class="up-main-info">
                                <h2 class="up-header">{{ $user->name }}</h2>
                                    <h6 class="up-sub-header">{{ $user->title }}</h6></div>
                                <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                        <path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path>
                                    </g>
                                </svg>
                            </div>
                            <div class="up-contents pt-4">
                                <div class="m-b">
                                    <div class="row m-b">
                                        <div class="col-sm-6 b-r b-b">
                                            <div class="el-tablo centered padded-v">
                                                <div class="value">{{ $user->history->count() }}</div>
                                                <div class="label">Total Access</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 b-b">
                                            <div class="el-tablo centered padded-v">
                                                <div class="value pb-3" style="font-size: 1.43rem;">{{ $last_access->created_at->diffForHumans()}}</div>
                                                <div class="label">Last Access</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="padded">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 pt-4">
                        <a class="element-box el-tablo" href="/rfid/public/">
                            <div class="label">Back to Access Screen</div>
                            <div class="value ml-4 pl-2 pt-3"><i class="os-icon os-icon-common-07"></i></div>
                        </a>
                    </div>
                </div>
               
            </div>
            
            <div class="col-sm-5">
                <div class="element-wrapper">
                    <div class="element-box">
                        <h6 class="element-header">User Activity</h6>
                        <div class="timed-activities compact">
                            @foreach ($history as $key => $history)
                                <div class="timed-activity">
                                <div class="ta-date"><span>{{ \Carbon\Carbon::parse($key)->format('jS F, Y') }}</span></div>
                                    <div class="ta-record-w">
                                        @foreach ($history as $sub_history)
                                            <div class="ta-record">
                                            <div class="ta-timestamp"><strong>{{ $sub_history->created_at->format('h:i:s') }}</strong> {{ $sub_history->created_at->format('a') }}</div>
                                                <div class="ta-activity">{{ $user->name }} is accessed with card number <a href="#">{{$user->card_id }}</a> in the system</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

@section('scripts')
    <script>
         
      var Main = {
          
          data() {
              return {
                
              }
          },
          mounted() {
          },
          methods: {
          
          }
      }
    </script>
@append