<?php

class ListAction implements ActionInterface
{
    public function __invoke(Request $request): Response
    {
        $list = new \stdClass();
        $list->bridges = [];
        $list->total = 0;

        $bridgeFactory = new BridgeFactory();

        foreach ($bridgeFactory->getBridgeClassNames() as $bridgeClassName) {
            $bridge = $bridgeFactory->create($bridgeClassName);

            $list->bridges[$bridgeClassName] = [
                'status'        => $bridgeFactory->isEnabled($bridgeClassName)
                                    ? xlat('misc:active')
                                    : xlat('misc:inactive'),
                'uri'           => $bridge->getURI(),
                'donationUri'   => $bridge->getDonationURI(),
                'name'          => $bridge->getName(),
                'icon'          => $bridge->getIcon(),
                'parameters'    => $bridge->getParameters(),
                'maintainer'    => $bridge->getMaintainer(),
                'description'   => $bridge->getDescription()
            ];
        }
        $list->total = count($list->bridges);
        return new Response(Json::encode($list), 200, ['content-type' => 'application/json']);
    }
}
