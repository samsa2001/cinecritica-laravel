<div class="form-control">
    <label for="titulo">Titulo</label>
    <input type="text" name="titulo" class="form-control" id="titulo" value="{{ old('titulo',$post->titulo) }}">
    @error('titulo')
    <small class="text-red-500">{{$message}}</small>
    @enderror
</div>
<div class="form-control">
    <label for="slug">URL limpia</label>
    <input type="text" name="slug" class="form-control" value="{{ old('slug',$post->slug) }}">
    @error('slug')
    <small class="text-red-500">{{$message}}</small>
    @enderror
</div>
<div class="form-control">
    <label for="conetenido">Contenido</label>
    <textarea id="conetenido" name="conetenido" class="form-control w-full" rows="3">{{ old('contenido',$post->contenido) }}</textarea>

    @error('conetenido')
    <small class="text-red-500">{{$message}}</small>
    @enderror
</div>
<div class="lg:flex flex-row">
    <div class="form-control lg:basis-1/3 lg:mr-3">
        <label for="categoria_id">Categoria</label>
        <select name="categoria_id" id="categoria_id" class="form-control">
            @foreach ($categorias as $titulo=>$cat_id)
            <option {{ $post->categoria_id == $cat_id ? 'selected="selected"':''}} value="{{ $cat_id }}">{{ $titulo }}</option>
            @endforeach
        </select>
    </div>
</div>
@if ( isset($task) && $task == 'edit' )
<div class="form-control mt-2">
    <label for="imagen">Imagen</label>
    <input type="file" name="image" id="imagen">
</div>
@endif
<input type="submit" value="Enviar" class="btn btn-slate my-3">