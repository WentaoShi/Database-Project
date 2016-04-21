## Update Apr 20:

写、删除diary，diary列表，在Homepage展示最近三个diary。

## Update Apr 18:

做完了上传头像照片的功能，然后在home页可以展示头像。未上传头像的user展示一张默认头像。已上传头像的用户可以更改头像。


## 说明
咱们就用GitHub来version control吧，有什么进展都写在这里，省的做重复了。

## Progress:

已完成:
- index done
- automatically insert table done
- register done
- login done
- home page - half done
  
待完成:
- home page
  - personal information done
    - 显示头像
    - 显示 dairy
    - 显示签名
    - 显示 photo
    - 显示 friend request
    - ... ...

## Problems:
- 通过link输入`./home.php?uname=xxx`可以进入任何人的页面，待修改为`uname=xxx&password=yyy`
- password is plaintext, needs to be encrypted.
