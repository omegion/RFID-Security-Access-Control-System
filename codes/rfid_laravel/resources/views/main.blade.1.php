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
        <transition name="fade" mode="out-in" :duration="300">  
            {{-- Waiting Screen --}}
            <div v-if="pageStatus == 'cardWaiting'" key="notToggled" class="auth-box-w wider centered">
                <div class="logo-w">
                    <transition name="fade" mode="out-in" :duration="300">
                        <div v-if="cardReading" key="toggled" class="icon-w logo-icon loading-icon">
                            <i class="os-icon os-icon-grid-18"></i>
                        </div>
                
                        <div v-if="!cardReading" key="notToggled" class="icon-w logo-icon">
                            <i class="os-icon os-icon-fingerprint"></i>
                        </div>
                    </transition>
                    
                </div>
                <h5 v-if="cardReading" class="auth-header">Card is reading...</h5>
                <h5 v-else class="auth-header">Please Instert Card</h5>
                <div class="logged-user-w pb-5">
                </div>
            </div>
            {{-- Card Not Found Screen --}}
            <div v-else-if="pageStatus == 'cardNotFound'" key="toggled" class="auth-box-w wider centered">
                <div class="logo-w">
                    <div class="icon-w logo-icon-red"><i class="os-icon os-icon-cancel-circle"></i></div>
                </div>
                <h5 class="auth-header">Card is not found</h5>
                <div class="logged-user-w pb-5 pt-3">
                    <button class="btn btn-primary" @click="pageStatus = 'cardAdd', newCard.active = true">Create New Account</button>
                </div>
            </div>
            {{-- Card Add Screen --}}
            <div v-else-if="pageStatus == 'cardAdd'" key="toggled" class="auth-box-w wider centered">                
                <h5 class="auth-header pt-4">Create New Account</h5>
                <div class="logged-user-w pb-5 pt-3">
                    <div>
                        <fieldset class="form-group text-left mt-2">
                            <div class="row pr-3 pl-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for=""> First Name</label>
                                        <input v-model="newCard.firstname" class="form-control" placeholder="First Name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input v-model="newCard.lastname" class="form-control" placeholder="Last Name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input v-model="newCard.title" class="form-control" placeholder="Title" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Email Address</label>
                                        <input v-model="newCard.email" class="form-control" placeholder="Email Address" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="pl-3">
                                <button class="btn btn-primary" @click="saveCard()">Save</button>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            {{-- Card Found Screen --}}
            <div v-else-if="pageStatus == 'cardFound'" key="toggled" class="auth-box-w wider centered">
                <div class="logo-w">
                    <div class="icon-w logo-icon"><i class="mdi mdi-checkbox-marked-circle-outline"></i></div>
                </div>
                <h5 class="auth-header">Welcome back!</h5>
                <div class="logged-user-w" style="    height: 132px;">
                    <div class="avatar-w"><img alt="" src="http://light.pinsupreme.com/img/avatar1.jpg"></div>
                    <div class="logged-user-name">@{{ user.name }}</div>
                    <div class="logged-user-role">@{{ user.title }}</div>
                </div>
            </div>
        </transition>  
        
    </div>
</body>
@endsection

@section('scripts')
    <script>
         
      var Main = {
          
          data() {
              return {
                user: [],
                pageStatus: 'cardWaiting',
                cardReading: false,
                newCard: {
                    active: false,
                    firstname: null,
                    lastname: null,
                    title: null,
                    email: null,
                    cardID: null
                }
              }
          },
          mounted() {
              this.socket();
          },
          methods: {
            socket() {
                var that = this;
                window.Echo.channel('main-channel')
                    .listen('.user', (response) => {
                        console.log(response)
                        if (response.user !== null) {
                            that.cardReading = true;
                            setTimeout(function(){ 
                               that.pageStatus = 'cardFound';
                               that.user = response.user;
                               that.loadWaitingScreen();
                            }, 2000);
                            
                        }
                        else if (response.user == null) {
                            that.cardReading = true;
                            setTimeout(function(){ 
                                that.newCard.cardID = response.cardId;
                                that.pageStatus = 'cardNotFound';
                                that.user = response.user;
                                setTimeout(function(){
                                    if (!that.newCard.active) {
                                        that.loadWaitingScreen();
                                    }
                                }, 2000);
                            }, 2000);
                            
                        }
                       
                        // that.releaseTaskHistory.items = Object.values(response.task_histories);
                    });
            },
            loadWaitingScreen() {
                var that = this;
                setTimeout(function(){ 
                    that.cardReading = false;
                    that.pageStatus = 'cardWaiting';
                    that.user = [];
                }, 3000);
            },
            saveCard() {
                var that = this;
                axios.post('/rfid/public/card-add/'+that.newCard.cardID, {
                    firstname: that.newCard.firstname,
                    lastname: that.newCard.lastname,
                    title: that.newCard.title,
                    email: that.newCard.email
                })
                .then(function (response) {
                    console.log(response);
                    that.cardReading = false;
                    that.pageStatus = 'cardWaiting';
                    that.user = [];
                    that.newCard.active = false;
                })
                .catch(function (error) {
                    console.log(error.response);
                });
            }
          }
      }
    </script>
@append