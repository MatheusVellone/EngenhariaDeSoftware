<?php
if ($usuarioLogado['grupo_id'] == 1):
    ?>
    <div class="row">
        <?php
        echo $this->Form->create('departamento', array(
            'type' => 'get',
            'url' => array(
                'controller' => 'Requisicoes',
                'action' => 'index'
            )
        ));
        ?>
        <?php
        echo $this->Form->input('departamento_id', array(
            'class' => 'form-control',
            'div' => array(
                'class' => 'col-md-3'
            ),
            'empty' => 'Todos Departamentos',
            'selected' => $departamento
        ));
        ?>
        <?php
        echo $this->Form->end(
                array(
                    'before' => '<br>',
                    'label' => 'Filtrar',
                    'div' => array(
                        'class' => 'col-md-3'
                    ),
                    'class' => array(
                        'class' => 'btn btn-success',
                    )
                )
        );
        ?>
        <br>
        <?php
        echo $this->Html->link(
                'Meu Histórico', array(
            'controller' => 'Requisicoes',
            'action' => 'historico'
                ), array(
            'class' => 'btn btn-primary'
        ));
        ?>
    </div>
    <hr>
    <?php
endif;
?>
<div class="row">
    <div class="col-md-12 btn-group btn-group-justified">
        <?php
        $parametro = $this->request->params['pass'];
        $classeParametro[4] = 'btn-default';
        $classeParametro[0] = 'btn-default';
        $classeParametro[1] = 'btn-default';
        $classeParametro[2] = 'btn-default';
        $classeParametro[3] = 'btn-default';

        if ($parametro == null) {
            $classeParametro[4] = 'btn-primary';
        } else {
            $classeParametro[$parametro[0]] = 'btn-primary';
        }
        if (isset($departamento)) {
            $link_departamento = array('departamento_id' => $departamento);
        }
        echo $this->Html->link('Todos', array('action' => 'index', '?' => $link_departamento), array('class' => 'btn ' . $classeParametro[4]));
        echo $this->Html->link('Espera', array('action' => 'index', 0, '?' => $link_departamento), array('class' => 'btn ' . $classeParametro[0]));
        echo $this->Html->link('Em Andamento', array('action' => 'index', 1, '?' => $link_departamento), array('class' => 'btn ' . $classeParametro[1]));
        echo $this->Html->link('Resolvido', array('action' => 'index', 2, '?' => $link_departamento), array('class' => 'btn ' . $classeParametro[2]));
        echo $this->Html->link('Cancelado', array('action' => 'index', 3, '?' => $link_departamento), array('class' => 'btn ' . $classeParametro[3]));
        ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="text-center h4">
            Total de 
            <?php
            echo $this->Paginator->counter(array(
                'format' => __('{:count}')
            ));
            ?> requisições
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <?php $seta = '<span class="glyphicon glyphicon-sort"></span>'; ?>
                    <th><?php echo $this->Paginator->sort('equipamento_id', 'Equipamento ' . $seta, array('escape' => false)); ?></th>
                    <th><?php echo $this->Paginator->sort('departamento_id', 'Departamento ' . $seta, array('escape' => false)); ?></th>
                    <th><?php echo $this->Paginator->sort('tecnico_id', 'Técnico Responsável ' . $seta, array('escape' => false)); ?></th>
                    <th><?php echo $this->Paginator->sort('created', 'Data da Criação ' . $seta, array('escape' => false)); ?></th>
                    <th><?php echo $this->Paginator->sort('modified', 'Ultima Modificação' . $seta, array('escape' => false)); ?></th>
                    <th>Situação</th>
                    <th>Visualizar</th>
                    <th>Editar</th>
                    <th>Cancelar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requisicoes as $requisicao): ?>
                    <tr>
                        <td><?php echo h($requisicao['Equipamento']['nome']); ?></td>
                        <td><?php echo $requisicao['Departamento']['nome']; ?></td>
                        <td><?php echo $requisicao['Tecnico']['nome']; ?></td>
                        <td><?php echo date("d/m/Y H:i:s", strtotime($requisicao['Requisicao']['created'])); ?></td>
                        <td><?php echo date("d/m/Y H:i:s", strtotime($requisicao['Requisicao']['modified'])); ?></td>
                        <?php
                        $situacao_classe[0] = 'label-warning';
                        $situacao_classe[1] = 'label-primary';
                        $situacao_classe[2] = 'label-success';
                        $situacao_classe[3] = 'label-danger';
                        ?>
                        <td class="h5">
                            <div class="col-md-12 label <?php echo $situacao_classe[$requisicao['Situacao']['id']]; ?>">
                                <?php echo $requisicao['Situacao']['situacao']; ?>
                            </div>
                        </td>
                        <td class="actions">
                            <?php
                            echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array('action' => 'view', $requisicao['Requisicao']['id']), array('escape' => false));
                            ?>
                        </td>
                        <td class="actions">
                            <?php echo ($requisicao['Situacao']['id'] != 2 && $requisicao['Situacao']['id'] != 3) ? $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', array('action' => 'edit', $requisicao['Requisicao']['id']), array('escape' => false)) : ''; ?>
                        </td>
                        <td class="actions">
                            <?php echo ($requisicao['Situacao']['id'] != 2 && $requisicao['Situacao']['id'] != 3) ? $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $requisicao['Requisicao']['id']), array('escape' => false), 'Deseja realmente cancelar esta requisição?') : ''; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        $params = $this->Paginator->params();
        if ($params['pageCount'] > 1) {
            ?>
            <div class="pagination pagination-lg">
                <ul class="pagination">
                    <?php
                    echo $this->Paginator->first('<<', array('tag' => 'li'));
                    echo $this->Paginator->prev('<', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                    echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
                    echo $this->Paginator->next('>', array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
                    echo $this->Paginator->last('>>', array('tag' => 'li'));
                    ?>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>