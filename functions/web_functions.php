<?php
function get_ItemsByCategory($bdd, $category, $language)
{
  $query = "SELECT i.id, i.destination, itr.title
            FROM indexitems as i 
              INNER JOIN category as c ON i.id_Category = c.id AND c.name = ? 
              INNER JOIN indexitems_tr as itr ON i.id = itr.id 
              INNER JOIN languages as l ON itr.id_Language = l.id AND l.code = ?
            WHERE i.bVisible = 1
            ORDER BY i.sortOrder ASC";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('ss', $category, $language);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  return $result;
}

function get_LanguageImage($bdd, $language)
{
  $query = "SELECT image FROM languages WHERE code = ?";
  $stmt = $bdd->stmt_init();
  $stmt->prepare($query);
  $stmt->bind_param('s', $language);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
  $value = $result->fetch_assoc();
  return 'data:image/jpeg;base64,'.base64_encode( $value['image'] );
}
?>