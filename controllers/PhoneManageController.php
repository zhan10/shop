<?php
namespace backend\controllers;

use backend\models\Role;
use backend\models\Menu;
use backend\models\RoleMenu;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\web\UploadedFile;

/**
 * Dashboard controller
 */
class PhoneManageController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionRoleManage(){
        $role = new Role();
        if($role->load(Yii::$app->request->post())){
            $role->name = Yii::$app->request->post("Role")["name"];
            $role->created_at = date('Y-m-d H:i:s',time()+8*3600);
            $role->save();
            return $this->redirect(array('phone-manage/role-manage'));
        }else{
            return $this->render('role',["role"=>$role]);
        }
    }
    public function actionMenuManage(){
        $menu = new Menu();
        if($menu->load(Yii::$app->request->post())){
            //获取图片并且保存
            $img = UploadedFile::getInstances($menu, 'img');
            if(count($img)!=0){
                if(move_uploaded_file($img[0]->tempName,realpath(__DIR__ . '/../')."/uploads/" . $img[0]->name)){
                    $menu->img = "uploads/".$img[0]->name;
                }
            }
            $menu->name = Yii::$app->request->post("Menu")["name"];
            $menu->url = Yii::$app->request->post("Menu")["url"];
            $menu->login_status = Yii::$app->request->post("Menu")["login_status"];
            $menu->created_at = date('Y-m-d H:i:s',time()+8*3600);
            $menu->save();
            return $this->redirect(array('phone-manage/menu-manage'));
        }else{
            return $this->render('menu',["menu"=>$menu]);
        }
    }
    public function actionRoleList(){
        $par = Yii::$app->request->post();
        $data = Role::find()->andFilterWhere(['like','name',$par["searchPhrase"]])->orderBy('created_at DESC')->asArray()->all();
        $result = array(
            'current' => $par["current"],
            'rowCount' => $par["rowCount"],
            'rows' => $data,
            "total" => Role::find()->count()
        );
        return json_encode($result);
    }
    public function actionMenuList(){
        $par = Yii::$app->request->post();
        $data = Menu::find()->andFilterWhere(['like','name',$par["searchPhrase"]])->offset(($par["current"]-1)*10)->limit($par["rowCount"])->orderBy('created_at DESC')->asArray()->all();
        $result = array(
            'current' => $par["current"],
            'rowCount' => $par["rowCount"],
            'rows' => $data,
            "total" => Menu::find()->count()
        );
        return json_encode($result);
    }
    public function actionFindById(){
        $id = Yii::$app->request->post("id");
        $role = Role::find()->where(['id' => $id])->one();
        $sql = "select m.* from role_menu as r INNER JOIN phone_menu as m on r.mid=m.id WHERE r.rid = ".$id;
        $menu = Menu::find()->asArray()->all();
        $roleMenu = RoleMenu::findBySql($sql)->asArray()->all();
        foreach($menu as $k=>$v){
            foreach($roleMenu as $kay=>$value){
                if($v["id"]==$value["id"]){
                    unset($menu[$k]);
                }
            }
        }
        $data["roleName"] = $role->name;
        $data["electMenu"] = $roleMenu;
        $data["notElectMenu"] = $menu;
        return json_encode($data);
    }
    public function actionMenuSave(){
        $roleId = Yii::$app->request->post("roleId");
        $menuIds = Yii::$app->request->post("menus");
        $ids = explode(',',$menuIds);
        RoleMenu::deleteAll('rid = '.$roleId);
        for($i=0;$i<count($ids);$i++){
            $roleMenu = new RoleMenu();
            $roleMenu ->rid = $roleId;
            $roleMenu ->mid = $ids[$i];
            $roleMenu->insert();
        }
        return $this->redirect(array('phone-manage/role-manage'));
    }
    public function actionDelMenu(){
        $menuId = Yii::$app->request->post("id");
        Menu::deleteAll('id='.$menuId);
        RoleMenu::deleteAll('mid='.$menuId);
        return true;
    }
    public function actionFindMenu(){
        $menuId = Yii::$app->request->post("id");
        $menu = Menu::find()->where(['id' => $menuId])->asArray()->one();
        return json_encode($menu);
    }
    public function actionEdit(){
        $id = Yii::$app->request->post("id");
        $name = Yii::$app->request->post("Menu")["name"];
        $url = Yii::$app->request->post("Menu")["url"];
        $loginStatus = Yii::$app->request->post("Menu")["login_status"];
        $menu = new Menu();
        //获取图片并且保存
        $img = UploadedFile::getInstances($menu, 'img');
        if(count($img)!=0){
            if(move_uploaded_file($img[0]->tempName,realpath(__DIR__ . '/../')."uploads/" . $img[0]->name)){
                $img = "uploads/".$img[0]->name;
                Menu::updateAll(['name'=>$name,'url'=>$url,'img'=>$img,'login_status'=>$loginStatus],'id='.$id);
            }
        }else{
            Menu::updateAll(['name'=>$name,'url'=>$url,'login_status'=>$loginStatus],'id='.$id);
        }
        return $this->redirect(array('phone-manage/menu-manage'));
    }
    public function actionFindRoleMenu(){
        $id = Yii::$app->request->get("id");
        $sql = "select m.name,m.url,m.img,m.login_status from role_menu as r INNER JOIN phone_menu as m on r.mid=m.id WHERE r.rid = ".$id;
        $roleMenu = RoleMenu::findBySql($sql)->asArray()->all();
        for($i=0;$i<count($roleMenu);$i++){
            $roleMenu[$i]["img"] = "https://sadmin.greenlandilife.com/backend/web/".$roleMenu[$i]["img"];
        }
        return json_encode($roleMenu);
    }
}
