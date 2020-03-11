<?php
namespace Fluxa\Persistence;

use Fluxa\Entity\Fluxo;
use \Slim\PDO\Database as PDO;

class FluxoDAO {

	public function __construct() {

	}

	public function salvar(Fluxo $fluxo) {

		if (empty($fluxo->getId())) {

			$strSQL = "INSERT INTO fluxo(id_usuario_oferece, id_usuario_necessita, id_recurso, status) ";
			$strSQL .= "VALUES (:id_usuario_oferece, :id_usuario_necessita, :id_recurso, :status)";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
                        
                      //  print_r( $fluxo ); die(" ");

			$preSQL->bindValue(":id_usuario_oferece", $fluxo->getIdUsuarioOferece());
			$preSQL->bindValue(":id_usuario_necessita", $fluxo->getIdUsuarioNecessita());
			$preSQL->bindValue(":id_recurso", $fluxo->getIdRecurso());
			$preSQL->bindValue(":status", $fluxo->getStatus());

			$preSQL->execute();

			$fluxo->setId(ConexaoPDO::getInstance()->lastInsertId());

		} else {

			$strSQL = "UPDATE fluxo SET ";
			$strSQL .= "status = :status ";
			$strSQL .= "WHERE id = :id";

			$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

			$preSQL->bindValue(":status", $fluxo->getStatus());
			$preSQL->bindValue(":id", $fluxo->getId());

			$preSQL->execute();

		}

		return $fluxo;

	}

	public function getId ($id_recurso, $id_usuario_oferece, $id_usuario_necessita, $coluna = "id"){


            $oConn = new \library\persist\PDOConnection(); 
            $sql = "select ".$coluna." from fluxo where id_recurso = " . $id_recurso. " and id_usuario_necessita = ". $id_usuario_necessita.
            " and id_usuario_oferece = " . $id_usuario_oferece . " order by id desc "; // " $preSQL->fetchAll(PDO::FETCH_CLASS, "
            
                      
            $ar = \library\persist\connAccess::fetchData($oConn, $sql);
          
            
           // print_r( $ar  );die(" ". $sql . $ar[0]["id"]);
            
            if ( count($ar) > 0 ){
                return $ar[0][$coluna];
            }
            
            return null;
	}

	public function buscarPorUsuario($idUsuario) {

		if(empty($idUsuario)){
			return null;
		}

		$strSQL = "SELECT * FROM fluxo ";
		$strSQL .= "WHERE id_usuario_necessita = :id_usuario1 ";
		$strSQL .= "OR id_usuario_oferece = :id_usuario2 ";
		$strSQL .= "ORDER BY id DESC ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		$preSQL->bindValue(":id_usuario1", $idUsuario);
		$preSQL->bindValue(":id_usuario2", $idUsuario);

		$preSQL->execute();

		return $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Fluxo");

	}

	public function buscarPorId($idFluxo, $idUsuario = null) {

		if (empty($idFluxo)) {
			return null;
		}

		$strSQL = "SELECT * FROM fluxo ";
		$strSQL .= "WHERE id = :id ";

		if(!empty($idUsuario)){
			$strSQL .= "AND id_usuario = :id_usuario ";	
		}

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);
		$preSQL->bindValue(":id", $idFluxo);
		
		if(!empty($idUsuario)){
			$preSQL->bindValue(":id_usuario", $idUsuario);
		}

		$preSQL->execute();

		$result = $preSQL->fetchAll(PDO::FETCH_CLASS, "Fluxa\Entity\Fluxo");

		if (count($result) > 0) {
			return $result[0];
		}

		return null;

	}

	public function getTotalQtdePorUsuario($idUsuario) {

		if(empty($idUsuario)){
			return null;
		}

		$strSQL = "SELECT COUNT(*) FROM fluxo ";
		$strSQL .= "WHERE id_usuario_necessita = :id_usuario1 ";
		$strSQL .= "OR id_usuario_oferece = :id_usuario2 ";

		$preSQL = ConexaoPDO::getInstance()->prepare($strSQL);

		$preSQL->bindValue(":id_usuario1", $idUsuario);
		$preSQL->bindValue(":id_usuario2", $idUsuario);

		$preSQL->execute();

		return $preSQL->fetchColumn();

	}
        
          
        public function getListFilho($oConn, $id_recurso_pai, $tipo = "" ){
            
            $sql = "select f.date_insert as data, f.status, '' as descricao, f.id, us.nome as nome_oferece, re.nome as nome_recurso, us2.nome as nome_necessita "
                    . "  from fluxo f "
                    . "  left join recurso re on re.id = f.id_recurso "
                    . "  left join usuario us on us.id = f.id_usuario_oferece "
                    . "  left join usuario us2 on us2.id = f.id_usuario_necessita "
                    . ""
                    . " where 1 = 1 ";
            
            if ( $id_recurso_pai != ""){
                $sql .= " and f.id_recurso = ". $id_recurso_pai;
            }
            if ( $tipo != ""){
                $sql .= " and f.tipo = '". $tipo."' ";
            }
            
            $sql .= " order by f.id desc ";
            
            $lista = \library\persist\connAccess::fetchData($oConn, $sql);
              
            for ( $i = 0; $i < count($lista); $i++ ){
                $item = &$lista[$i];
                
                $item["descricao"] = $item["nome_necessita"] . " solicitou " . $item["nome_recurso"] . " ofertado por " . $item["nome_oferece"];
                
            }
            return $lista;
            
        }


}

?>
