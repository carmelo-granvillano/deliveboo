@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        @if ($errors->any())
          <div class="aler alert-danger pt-2">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> 
              @endforeach
            </ul>
          </div>  
        @endif

        <div class="row pt-3 pt-lg-0">
          <div class="col">
            <h1 class="text-center mt-3 fs-4 fw-bold text_color">Modifica un prodotto</h1>
          </div>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PATCH')



          <div class="row row mb-5 p-lg-3 background_color_y text_color box_shadows">

            {{-- SX --}}
            <div class="col-lg-6">
              {{-- Immagine --}}
              <div class="my-3 w-auto">
                <label for="image" class="form-label">Immagine</label>
                <input 
                  type="file" 
                  id="image" 
                  name='image' 
                  class="form-control @error('image') is-invalid @enderror">
                    <img 
                      class="mt-3 ms-3" 
                      id="preview" 
                      src="{{ $product->img_path }}" 
                      alt="" width="260px"/>
                        @if($product->getRawOriginal('img_path'))
                        <button id="delete-img" class="btn bottone text_color ms-2"><i class="fas fa-trash"></i></button>
                        @endif

                  @error('image')
                  <div class="alert alert-danger">{{ $message }}</div> 
                  @enderror
              </div>

              {{-- Disponibilità --}}
              <div class="mt-5 mb-3 w-auto">
                <label for="visibility" class="form-label">Disponibilità del prodotto</label>
                <select id="visibility" name="visibility" class="form-select" required>
                  <option {{ $product->visibility || (int) old('visibility') ? 'selected' : ''}} value="1">Disponibile</option>
                  <option {{ $product->visibility || (int) old('visibility') ? '' : 'selected' }} value="0">Non disponibile</option>
                </select>
              </div>

              {{-- Prezzo --}}
              <div class="my-3 w-auto">
                <label for="price" class="form-label">Prezzo</label>
                <input class="form-control @error('price') is-invalid @enderror" type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price') ? old('price') : $product->price }}" required>
              </div>
            {{-- End SX --}}  
            </div>



            {{-- DX --}}
            <div class="col-lg-6">
              {{-- Nome --}}
              <div class="my-3 w-auto">
                <label for="nome" class="form-label">Nome</label>
                <input 
                  name="name" 
                  type="text" 
                  class="form-control"
                  id="nome" 
                  value="{{ old('name', $product->name) }}"
                  required>
              </div>

              {{-- Descrizione --}}
              <div class="my-3 w-auto">
                <label for="descrizione" class="form-label">Descrizione</label>
                <textarea 
                  name="description" 
                  class="form-control" 
                  id="descrizione" 
                  cols="30" 
                  rows="8">{{ old('description', $product->description) }}</textarea>
              </div>

              {{-- Ingredienti --}}
              <div class="my-3 w-auto">
                <label for="ingredienti" class="form-label">Ingredienti</label>
                <textarea 
                  name="ingredient" 
                  class="form-control @error('ingredient') is-invalid @enderror" 
                  id="ingredienti" 
                  cols="25" 
                  rows="1"
                  required>{{ old('ingredient', $product->ingredient) }}</textarea> 
              </div>
            {{-- End DX --}}  
            </div>
            
            {{-- Bottoni --}}
            <div class="row text-center">
              {{-- Salva --}}
              <div class="col-6 text-end">
                <button type="submit" class="btn bottone text_color">
                  <i class="fas fa-save mt-1 fs-3"></i>
                </button>
              </div>

              <div class="col-6 text-start">
                <a href="{{ route('products.index') }}">
                  <button type="button" class="btn bottone text_color">
                    <i class="fas fa-window-close mt-1 fs-3"></i>
                  </button>
                </a>
              </div>
            </div>

          {{-- End Row   --}}
          </div>
        </form>  
      </div>
    </div>
  </div>
@endsection

@section('script-footer')
@parent
<script>
  const image = document.getElementById('image');
  const preview = document.getElementById('preview');
  image.addEventListener('change', function(event){
    let url = URL.createObjectURL(event.target.files[0]);
    preview.src = url;
    preview.onload = function(){
      URL.revokeObjectURL(preview.src); // remove memory
    }
  });

  const btnDeleteImg = document.getElementById('delete-img');
  btnDeleteImg?.addEventListener('click', function(event){
    event.preventDefault();
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete-img';
    input.value = true;
    btnDeleteImg.append(input);
    btnDeleteImg.parentNode.insertBefore(input, btnDeleteImg.nextSibling);
    btnDeleteImg.remove();
    image.value = '';
    preview.src = "<?= asset('storage/products/product-placeholder.jpeg') ?>";
  });
</script>
@endsection