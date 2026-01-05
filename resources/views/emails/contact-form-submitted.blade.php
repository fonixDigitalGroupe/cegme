<div>
    <p><strong>Nom :</strong> {{ $data['name'] }}</p>
    <p><strong>Email :</strong> {{ $data['email'] }}</p>
    @if(!empty($data['phone']))
        <p><strong>Téléphone :</strong> {{ $data['phone'] }}</p>
    @endif
    <p><strong>Sujet :</strong> {{ $data['subject'] }}</p>
    <hr>
    <p><strong>Message :</strong></p>
    <p>{{ $data['message'] }}</p>
</div>
