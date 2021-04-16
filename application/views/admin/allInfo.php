<table class="table table-bordered">
    <colgroup>
        <col width="20%" />
        <col width="20%" />
        <col width="30%" />
        <col width="20%" />
        <col width="*" />
    </colgroup>
    <thead>
        <tr>
            <th> TID </th>
            <th> ID </th>
            <th> Name </th>
            <th> Age </th>
            <th> Gender </th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($members as $member) : ?>
            <tr>
                <td><?= $member->PID ?></td>
                <td><?= $member->ID ?></td>
                <td><?= $member->name ?></td>
                <td><?= $member->age ?></td>
                <td><?= $member->gender ?></td>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>
