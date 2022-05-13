<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $email
 * @property string|null $phone
 * @property string|null $name
 * @property string $text
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'text'], 'required'],
            [['text'], 'string'],
            ['email', 'email'],
            [['email', 'name'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'name' => 'Name',
            'text' => 'Text',
        ];
    }

    public function sendEmail() {
        Yii::$app->mailer->compose([
            'html' => 'feedback-html', 'text' => 'feedback-text'
        ], 
        [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'text' => $this->text
        ])
            ->setFrom(Yii::$app->params['senderEmail'])
            ->setTo(Yii::$app->params['feedbackReceiverEmail'])
            ->setSubject('Новое сообщение из формы обратной связи')
            ->send();
    }
}
