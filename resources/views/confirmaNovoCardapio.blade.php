<!-- Modal -->
<div class="modal fade" id="cardapio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Atualizar Cardápio</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja atualizar o cardápio digital?</b>
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form action="{{url("/cardapio/digital")}}">
          <button type="submit" class="btn btn-primary">Atualizar Cardápio Digital</button>
        </form>
      </div>
    </div>
  </div>
</div>