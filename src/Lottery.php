<?php

namespace yii\lottery;

use lottery\Lottery as RealLottery;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Lottery extends Component
{
    /**@var LotteryInterface $lotteryClass */
    public $lotteryClass = null;

    /**@var AlgorithmInterface $algorithm */
    public $algorithm = null;

    private $lotteryInstance;

    public function init()
    {
        if ($this->lotteryClass === null) {
            throw new InvalidConfigException("lotteryClass must be set");
        }

        if ($this->algorithm !== null) {
            $this->algorithm = Yii::createObject($this->algorithm);
        }

        $lotteryObject = Yii::createObject($this->lotteryClass);

        $this->lotteryInstance = new RealLottery($lotteryObject, $this->algorithm);
    }

    public function run($userId, $activityId = 0)
    {
        return $this->lotteryInstance->run($userId, $activityId);
    }
}
