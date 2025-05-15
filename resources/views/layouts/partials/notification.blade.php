@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
       
    @else
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <script>
        iziToast.danger=  iziToast.error;
        iziToast.{{$message['level']}}({
            title: "{{$message['title']}}",
            message: '{{$message["message"]}}',
            position: 'topRight'
        });
    </script>
      
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
