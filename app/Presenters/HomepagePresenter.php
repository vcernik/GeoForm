<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    protected function createComponentAnswerForm(): Form
	{
		$form = new Form;
		$form->addText('lat', 'lat:')
			->setRequired('Vyberte bod na mapě')
			->addRule($form::FLOAT, 'Vyberte bod na mapě');

		$form->addText('lon', 'lon:')
			->setRequired('Vyberte bod na mapě')
			->addRule($form::FLOAT, 'Vyberte bod na mapě');

        $form->addReCaptcha('recaptcha', $label = '')
                ->setMessage('Are you a bot?');

		$form->addSubmit('send', 'Odeslat');
		$form->onSuccess[] = [$this, 'formSucceeded'];
		return $form;
	}

	public function formSucceeded(Form $form, $data): void
	{
		$time=new \DateTime();
		$data='
'.$time->format('Y-m-d').';'.$time->format('H:i:s').';'.$data->lat.';'.$data->lon;
		file_put_contents(__DIR__.'/../../www/result.txt',$data,FILE_APPEND);
		$this->redirect('success');
	}
}
