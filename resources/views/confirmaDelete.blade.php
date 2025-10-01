<!-- Modal -->
<div class="modal fade" id="produto_{{ $produto->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Excluir Produto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja desabilitar o produto <b>{{$produto->descricao}}?</b>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form action="{{url("/excluir/produto/$produto->id")}}">
          <button type="submit" class="btn btn-danger">Desabilitar</button>
        </form>
      </div>
    </div>
  </div>
</div>


