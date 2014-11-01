      <?php 
      include("../includes/core.php");
      $query = "SELECT * FROM services";
      $db->DoQuery($query, null);
      $num = $db->fetchAll();
      include("../includes/header.php");
      ?>

      <h1>Services</h1>

      <?php if (count($num) > 0): ?>
      <table id="checkins_table">
        <thead>
          <tr>
            <th><?php echo implode('</th><th>', array_keys(current($num))); ?></th>
          </tr>
        </thead>
        <tbody>
      <?php foreach ($num as $row): array_map('htmlentities', $row); ?>
          <tr>
            <td><?php echo implode('</td><td>', $row); ?></td>
          </tr>
      <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
      </div>
