<template>
<div>
  <h1>新增</h1>
  <a-form labelAlign="left" style="border: 1px solid #eee;margin-left: 20px;padding: 20px 0 0 20px;">
       <a-form-item 
        label="用户名"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
        
      >
        <a-input placeholder="请输入用户名"/>
      </a-form-item>
      <a-form-item
        label="年"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input placeholder="请输入年"/>
      </a-form-item>
      <a-form-item
        label="月"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  placeholder="请输入月" />
      </a-form-item>
      <br>
      <a-form-item
        label="基本薪资"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
          <a-input  :disabled="true" />
      </a-form-item>
      <a-form-item
        label="技能薪资"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  :disabled="true" />
      </a-form-item>
      <a-form-item
        label="平时加班合计补贴"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  :disabled="true" />
      </a-form-item>
       <a-form-item
        label="休日加班合计补贴"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
          <a-input :disabled="true" />
      </a-form-item>
      <a-form-item
        label="假日加班合计补贴"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input :disabled="true" />
      </a-form-item>
      <a-form-item
        label="津贴"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  :disabled="true" />
      </a-form-item>
       <a-form-item
        label="正常工作合计补贴"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  :disabled="true" />
      </a-form-item>
       <a-form-item
        label="夜班补贴"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
          <a-input  :disabled="true" />
      </a-form-item>
      <a-form-item
        label="移动内"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  :disabled="true" />
      </a-form-item>
      <a-form-item
        label="移动外"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  :disabled="true" />
      </a-form-item>
      <a-form-item
        label="社保"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input placeholder="请输入社保" />
      </a-form-item>
      <a-form-item
        label="所得税"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input placeholder="请输入所得税" />
      </a-form-item>
      <a-form-item
        label="差旅费"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  :disabled="true" />
      </a-form-item>
      <br>
      <a-form-item
        label="合计薪资"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
          <a-input  :disabled="true" />
      </a-form-item>
      <a-form-item
        label="状态"
        :label-col="formItemLayout.labelCol"
        :wrapper-col="formItemLayout.wrapperCol"
      >
        <a-input  :disabled="true" />
      </a-form-item>
      <a-form-item style="">
        <a-button type="primary" style="margin-right: 30px;width: 200px;">
          提交
        </a-button>
        <a-button style="width: 200px;">
          重置
        </a-button>
      </a-form-item>
    </a-form>


    //test 
    
</div>
</template>

<script>
const formItemLayout = {
  labelCol: { span: 2 },
  wrapperCol: { span: 2 },
};
export default {
  name: 'Add',
  data() {
    return {
      formItemLayout
    }
  }
}
</script>

<style scoped>
  h1 {
    padding: 40px;
  }
</style>