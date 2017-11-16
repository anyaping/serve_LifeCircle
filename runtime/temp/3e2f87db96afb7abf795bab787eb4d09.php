<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:56:"D:\tp5.0\public/../application/admin\view\user\sort.html";i:1510385874;}*/ ?>

                <?php if(is_array($results) || $results instanceof \think\Collection || $results instanceof \think\Paginator): $i = 0; $__LIST__ = $results;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr class="active">
                        <td><?php echo $vo['id']; ?></td>
                        <td><img width="50px" height="50px" src= "__LOGO__<?php echo $vo['img']; ?>"></td>
                        <td><?php echo $vo['name']; ?></td>
                        <td><?php echo $vo['abstract']; ?></td>
                        <td><?php echo $vo['sex']; ?></td>
                        <td><?php echo $vo['birthday']; ?></td>
                        <td><?php echo $vo['address1']; ?></td>
                        <td><?php echo $vo['address2']; ?></td>
                        <td><?php echo $vo['level']; ?></td>
                        <td><?php echo $vo['phone']; ?></td>
                        <td><?php echo $vo['email']; ?></td>
                        <td><?php echo $vo['money']; ?></td>
                        <td><?php echo date('Y-m-d',$vo['time']); ?></td>
                    </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>