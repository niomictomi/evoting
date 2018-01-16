@extends('layouts.global')

@section('activity', 'Reset - Root')

@section('title', 'Reset')

@section('content')
    
<div class="card">
    <div class="card-block">
        <div class="title-block">
            <h4 class="title">Reset Database</h4>
            <p class="title-description">Melakukan penghapusan seluruh data</p>
        </div>

        <div id="reset">
            <button class="btn btn-danger" @click.prevent="reset">Reset Sekarang</button>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    let reset = new Vue({
        el: '#reset',
        methods: {
            reset() {
                this.inputPassword()
            },
            passwordCheck(pass) {
                let that = this
                $.ajax({
                    type: 'post',
                    url: '{{ route('root.password.check') }}',
                    data: 'password=' + pass,
                    success: function (response) {
                        if(undefined !== typeof response.success)
                            that.areYouSure()
                    },
                    error: function () {
                        swal({
                            title: 'Ups',
                            icon: 'error',
                            text: 'Kata sandi tidak sesuai !'
                        })
                    }
                })
            },
            inputPassword() {
                let that = this
                swal({
                    title: 'Masukkan kata sandi untuk konfirmasi',
                    content: {
                        element: 'input',
                        attributes: {
                            placeholder: 'Masukkan kata sandi',
                            type: 'password'
                        }
                    }
                }).then(function (response) {
                    let pass = response

                    that.passwordCheck(response)
                })
            },
            areYouSure() {
                let that = this
                swal({
                    title: 'Apa anda yakin ?',
                    icon: 'warning',
                    text: 'Aksi ini tidak bisa diurungkan',
                    buttons: {
                        cancel: "Batal",
                        confirm: "Lanjutkan"
                    }
                }).then(function (response) {
                   if(response) {
                        that.process()
                   }
                })
            },
            process() {
                swal({
                    title: 'Harap Tunggu',
                    text: 'Sedang melakukan proses reset. Harap tidak menutup atau memuat ulang halaman',
                    button: false,
                    closeOnClickOutside: false,
                    icon: '{{ asset('images/material-loading.gif') }}'
                })

                $.ajax({
                    type: 'post',
                    url: '{{ route('root.reset') }}',
                    data: '_method=delete',
                    success: function (response) {
                        swal.close()
                        if(response.success !== undefined) {
                            swal({
                                title: 'Berhasil !',
                                text: response.success
                            })
                        }
                    },
                    error: function (response) {
                        swal({
                            title: 'Gagal !',
                            text: 'Gagal melakukan reset, coba beberapa saat lagi !'
                        })
                    }
                })
            }
        }
    })
</script>
@endpush