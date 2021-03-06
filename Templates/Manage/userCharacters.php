<?php

require_once dirname(__FILE__) . "/../../Services/Profile/getUserCharacters.php";

?>

<table class="table mt-3 text-center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Level</th>
            <th>Health points</th>
            <th>Coins</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="characters">
    <?php foreach($characters as $character): ?>
        <tr id="character-<?=$character->id?>">
            <th><?=$character->id;?></th>
            <td><span id="name-<?=$character->id;?>"><?=$character->name;?></span></td>
            <form class="input-group" id="form-<?=$character->id?>">
                <input type="hidden" name="id" value="<?=$character->id?>" form="form-<?=$character->id?>">
                <td>
                    <input style="max-width: 50px" class="input-group-number" type="number"
                           name="level" value="<?=$character->level;?>" form="form-<?=$character->id?>">
                </td>
                <td>
                    <input style="max-width: 50px" class="input-group-number" type="number"
                           name="health_points" value="<?=$character->health_points;?>" form="form-<?=$character->id?>">
                </td>
                <td>
                    <input style="max-width: 100px" class="input-group-number" type="number"
                           name="coins" value="<?=$character->coins;?>" form="form-<?=$character->id?>">
                </td>
            </form>
            <td>
                <i class="fas fa-trash ml-2" onclick="profile.deleteCharacter(<?=$character->id;?>)"></i>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
