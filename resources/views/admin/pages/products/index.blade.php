@extends('admin.layouts.app')

@section('title', 'Gestão de produtos')

@section('content')
    <h1>Exibindo os produtos</h1>
<a href="{{ route('products.create') }}" class="btn btn-primary">Cadastrar</a>
<hr>

    <form action="{{ route('products.search') }}" method="post" class="form form-inline">
        @csrf
        <input type="text" name="filter" placeholder="Filtrar:" class="form-control" value="{{$filters['filter'] ?? ''}}">
        <button type="submit" class="btn btn-info">Pesquisar</button>
    </form>

<table border="table-stripped">
    <thead>
        <th>Imagem</th>
        <th>Nome</th>
        <th>Preço</th>
        <th width="100">Ações</th>
    </thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            <td>
                @if($product->image)
                    <img src="{{ url("store/{$product->image}") }}" alt="{{$product->name}}" style="max-width: 100px;">
                @endif
            </td>
        <td>{{$product->name}}</td>
        <td>{{$product->price}}</td>
        <td>
            <a href="{{route('product.edit', $product->id)}}">Editar</a>
            <a href="{{route('product.show', $product->id)}}">Detalhes</a>
        </td>
        </tr>
    @endforeach
    </tbody>
</table>

@if(isset($filters))
{!!$products->appends($filters)->links()!!}
@else
{!!$products->links()!!}
@endif



@endsection

    {{-- @component('admin.components.card')
    @slot('title')
        <h1>Titulo Card</h1>
    @endslot
        Um card de exemplo
    @endcomponent

    <hr>

    @include('admin/includes/alerts', ['content' => 'Alerta de precos de produtos'])
    
    <hr>

    @if(isset ($products))
        @foreach ($products as $product)
            <p class="@if($loop->last) last @endif">{{$product}}</p>
    @endforeach
    @endif

    <hr>

    @forelse ($products as $product)
            <p>{{$product}}</p>
        @empty
            <p>Não existe produstos cadastrados.</p>
    @endforelse

    <hr

    @if($teste === '123')
    É igual
    @elseif($teste === 123)
    É igual a 123
    @else
    É diferente
    @endif

    @unless ($teste === '123')
        teste
    @else
        teste else
    @endunless

    @isset($teste2)
        <p>{{$teste2}}</p>
    @endunless

    @empty($teste3)
        <p>Vazio...</p>
    @endempty

    @auth
        <p>Autenticação</p>
    @else
        <p>Não está autenticado</p>
    @endauth

    @guest
        <p>Não está autenticado</p>
    @endguest

    @switch($teste)
        @case(1)
            Igual 1
            @break
        @case(2)
            Igual 2
            @break
        @case(123)
            Igual 123
            @break
        @default
            Default
    @endswitch
@endsection

@push('styles')
<style>
        .last{background: #ccc}
</style>
@endpush

@push('scripts')
    <script>
        document.body.style.background = '#efefef'
    </script>
@endpush --}}